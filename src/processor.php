<?php
namespace xpspl;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \Closure,
    \InvalidArgumentException,
    \xpspl\processor\signal as processor_signals;

/**
 * Processor
 *
 * The brainpower of xpspl.
 * 
 * As of v0.3.0 the loop is now run in respect to the currently available handles,
 * this prevents the processor from running contionusly forever when there isn't anything
 * that it needs to do.
 *
 * To achieve this the processor uses routines for calculating when to run and 
 * shutdowns when no more are available.
 *
 * The queue storage has also been improved in 0.3.0, previously the storage used
 * a non-index and index based storage, the storage now uses only a single array.
 */
class Processor {

    /**
     * Statefull object
     */
    use State, Storage;

    /**
     * Storage container node indices
     */
    const HASH_STORAGE = 0;
    const COMPLEX_STORAGE = 1;
    const INTERRUPT_STORAGE = 2;

    /**
     * Interuption Types
     */
    const INTERRUPT_PRE = 0;
    const INTERRUPT_POST = 1;

    /**
     * Last signal added to the processor.
     * 
     * @var  object
     */
    protected $_last_sig_added = null;

    /**
     * History of events
     * 
     * @var  array
     */
    protected $_history = [];

    /**
     * Current event in execution and hierachy
     * 
     * @var  object  \xpspl\Event
     */
    protected $_event = [];

    /**
     * Routine data.
     * 
     * @var  array
     */
    private $_routines = [];

    /**
     * Signal exceptions rather than throwing them.
     *
     * @var  boolean
     */
    private $_signal_exception = null;

    /**
     * Signal registered for the processor exception signals.
     */
    private $_processor_handle_signal = null;

    /**
     * Currently executing signal and hierachy
     */
    private $_signal = [];

    /**
     * Starts the processor.
     *
     * @param  boolean  $signal_history  Store a history of all signals.
     * 
     * @return  void
     */
    public function __construct($signal_history = true)
    {
        if ($signal_history === false) {
            $this->_history = false;
        }
        $this->_register_error_handler();
        $this->set_state(STATE_DECLARED);
        $this->flush(); 
    }

    /**
     * Registers the processor error signal handler.
     *
     * TODO
     * Create a suitable error handler
     * 
     * @return  void
     */
    protected function _register_error_handler()
    {
        if (null === $this->_processor_handle_signal) {
            $this->_processor_handle_signal = new \xpspl\processor\signal\Processor_Errors();
        } else {
            $queue = $this->search_signals($this->_processor_handle_signal);
            if ($queue->count() !== 0) {
                return true;
            }
        }
        // TODO allow for specifing a context for the event rather than the 
        // event itself and recieve it as the first parameter
        $processor = $this;
        $this->signal($this->_processor_handle_signal, function() use ($processor){
            $exception = $processor->current_signal()->get_exception();
            if (null !== $exception) {
                $trace = array_reverse($exception->getTrace());
                $error = get_class_name($exception);
                $message = $exception->getMessage();
                $line = $exception->getLine();
                $file = $exception->getFile();
            } else {
                $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
                $stack = array_pop($trace);
                $message = $processor->current_signal()->get_error();
                $error = get_class_name($processor->current_signal());
                $file = $stack['file'];
                $line = $stack['line'];
            }
            $stacktrace = '';
            $i=0;
            foreach ($trace as $_trace) {
                if (!isset($_trace['file']) 
                    || strpos($_trace['file'], XPSPL_PATH) === false) {
                    $stacktrace .= sprintf(
                        $i.': # %s:%s(%s)'.PHP_EOL,
                        (isset($_trace['file'])) ? $_trace['file'] : '-',
                        (isset($_trace['line'])) ? $_trace['line'] : '-',
                        ((isset($_trace['class'])) 
                            ? $_trace['class'] . $_trace['type'] : '') 
                        . $_trace['function']
                    );
                    $i++;
                }
            }
            echo sprintf(
                'Exception: %s'.PHP_EOL.''
                .'Message: %s'.PHP_EOL.''
                .'Line: %s'.PHP_EOL.''
                .'File: %s'.PHP_EOL.''
                .'Trace:'.PHP_EOL.''
                .'%s',
                $error,
                $message,
                $line,
                $file,
                $stacktrace
            );
        });
    }

    /**
     * Cleans out the event history.
     *
     * @return  void
     */
    public function erase_history()
    {
        if (false === $this->_history) {
            return;
        }
        $this->_history = [];
    }

    /**
     * Start the event loop.
     *
     * @todo unittest
     * 
     * @param  null|integer  $ttr  Number of milliseconds to run the loop.
     * 
     * @return  void
     */
    public function loop($ttr = null)
    {
        if (null !== $ttr) {
            $processor = $this;
            $awake_func = function() use ($processor) {
                $processor->shutdown();
            };
            $this->signal(
                new \xpspl\time\SIG_Awake($ttr, TIME_MILLISECONDS), 
                $awake_func
            );
        }
        $this->emit(new processor\SIG_Startup());
        while($this->_routine()) {
            // check state
            if ($this->get_state() === STATE_HALTED) break;
            $signals = $this->_routine->get_signals();
            if (count($signals) !== 0) {
                foreach ($signals as $_signal) {
                    $this->emit($_signal[0], $_signal[1]);
                }
            }
            $idle = $this->_routine->get_idle();
            // check for idle function
            if (null !== $idle) {
                $idle->idle($this);
            }
        }
        $this->emit(new processor\SIG_Shutdown());
    }

    /**
     * Runs the complex signal routine for the processor loop.
     *
     * @todo unittest
     * 
     * @return  boolean|array
     */
    private function _routine()
    {
        $return = false;
        $this->_routine = new Routine();
        // allow for external shutdown signal before running anything
        if ($this->get_state() === STATE_HALTED) return false;
        foreach ($this->_storage[self::COMPLEX_STORAGE] as $_key => $_node) {
            try {
                // Run the routine
                $_routine = $_node[0]->routine($this->_history);
                // Did it return true
                if (true === $_routine) {
                    $_routine = $_node[0]->get_routine();
                    // Is the routine a routine?
                    if (!$_routine instanceof Routine) {
                        throw new \Exception(sprintf(
                            "%s did not return a routine",
                            get_class($_node[0])
                        ));
                    }
                    // Get all required data and reset the routine
                    $_signals = $_routine->get_signals();
                    $_idle = $_routine->get_idle();
                    $_routine->reset();
                    // Check signals
                    if (null !== $_signals && count($_signals) != 0) {
                        foreach ($_signals as $__signal) {
                            list($__sig, $__event) = $__signal;
                            // ensure it has not exhausted
                            if (false === $this->has_signal_exhausted($__sig)) {
                                $return = true;
                                $this->_routine->add_signal($__sig, $__event);
                            }
                        }
                    }
                    // Check for an idle function
                    if (null !== $_idle) {
                        $return = true;
                        $this->_routine->add_idle($_idle);
                    }
                }
            // Catch any problems that happended and signal them
            } catch (\Exception $e) {
                $this->emit(new processor_signals\Routine_Calculation_Error(
                    "An error has occured during a routine calculation"
                ),  new processor\event\Error([$e, $_node]));
            }
        }
        return $return;
    }

    /**
     * Returns the current routine object.
     *
     * @todo unittest
     *
     * @return  null|object
     */
    public function get_routine(/* ... */)
    {
        return $this->_routine;
    }

    /**
     * Determines if the given signal has exhausted.
     * 
     * @param  string|integer|object  $queue
     * 
     * @return  boolean
     */
    public function has_signal_exhausted($signal)
    {
        $queue = $this->search_signals($signal);
        if (null === $queue) {
            return true;
        }
        return true === $this->queue_exhausted($queue);
    }

    /**
     * Determine if all queue handles are exhausted.
     *
     * @param  object  $queue  \xpspl\Queue
     * 
     * @return  boolean
     */
    public function queue_exhausted($queue)
    {
        if ($queue->count() === 0) {
            return true;
        }
        $queue->reset();
        while($queue->valid()) {
            // if a non exhausted handle is found return false
            if (!$queue->current()[0]->is_exhausted()) {
                return false;
            }
            $queue->next();
        }
        return true;
    }

    /**
     * Removes a signal handler.
     *
     * @param  mixed  $signal  Signal instance or signal.
     * @param  mixed  $handle  Handle instance or identifier.
     * 
     * @return  void
     */
    public function remove_handle($signal, $handle)
    {
        $queue = $this->search_signals($signal);
        if (null === $queue) {
            return;
        }
        return $queue->dequeue($handle);
    }

    /**
     * Empties the storage, history and clears the current state.
     *
     * @return void
     */
    public function flush(/* ... */)
    {
        $this->_storage = [[], [], []];
        if (false !== $this->_history){
            $this->_history = [];
        }
        $this->set_state(STATE_DECLARED);
    }

    /**
     * Registers an object listener.
     *
     * @param  object  $listener  xpspl\Listener
     *
     * @return  void
     */
    public function listen(Listener $listener)
    {
        foreach ($listener->_get_signals() as $_signal) {
            $this->signal($_signal[0], $_signal[1]);
        }
        $listener->reset();
    }

    /**
     * Creates a new signal handler.
     *
     * @param  string|int|object  $signal  Signal to attach the handle.
     * @param  object  $callable  Signal handler
     *
     * @return  object|boolean  Handle, boolean if error
     */
    public function signal($signal, $handle)
    {
        if (!$handle instanceof Handle) {
            if (!is_callable($handle)) {
                $this->emit(new processor_signals\Invalid_Handle(
                       "Invalid handle given to the handle method" 
                    ), new processor\event\Error([func_get_args()])
                );
                return false;
            }
            $handle = new Handle($handle);
        }
        $queue = $this->register_signal($signal);
        if (false !== $queue) {
            if (is_array($queue)) {
                $queue = $queue[0][0];
            }
            $queue->enqueue($handle, $handle->get_priority());
        }
        return $handle;
    }

    /**
     * Registers a signal a new signal
     *
     * @param  string|integer|object  $signal  Signal
     *
     * @return  boolean|object  false|xpspl\Queue
     */
    public function register_signal($signal)
    {
        $queue = false;

        if (!$signal instanceof \xpspl\signal\Standard) {
            try {
                $signal = new Signal($signal);
            } catch (\InvalidArgumentException $e) {
                $this->emit(new processor_signals\Invalid_Signal(
                    "Invalid signal given to register"
                ),  new processor\event\Error([$exception, $signal]));
                return false;
            }
        }

        $search = $this->search_signals($signal);

        if (null !== $search) {
            return $search;
        }

        if (!$queue) {
            $queue = new Queue();
            if (!$signal instanceof \xpspl\signal\Complex) {
                $this->_storage[self::HASH_STORAGE][(string) $signal->get_info()] = [
                    $signal, $queue
                ];
            } else {
                $id = spl_object_hash($signal);
                $this->_storage[self::COMPLEX_STORAGE][$id] = [$signal, $queue];
            }
        }
        $this->_last_sig_added = $signal;
        return $queue;
    }

    /**
     * Searches for a signal in storage returning its storage queue if found,
     * optionally the index can be returned.
     * 
     * @param  string|int|object  $signal  Signal to search for.
     * @param  boolean  $index  Return the index of the signal.
     * 
     * @return  null|object  null|Queue
     */
    public function search_signals($signal, $index = false) 
    {
        if ($signal instanceof \xpspl\signal\Complex) {
            $id = spl_object_hash($signal);
            if (isset($this->_storage[self::COMPLEX_STORAGE][$id])) {
                if ($index) return $id;
                return $this->_storage[self::COMPLEX_STORAGE][$id][1];
            }
            return null;
        }
        if ($signal instanceof \xpspl\Signal) {
            $signal = $signal->get_info();
        }
        $signal = (string) $signal;
        if (isset($this->_storage[self::HASH_STORAGE][$signal])) {
            if ($index) return $signal;
            return $this->_storage[self::HASH_STORAGE][$signal][1];
        }
        return null;
    }

    /**
     * Runs the evaluation for the registered complex signals using the given
     * signal.
     *
     * @param  string|object|int  $signal  Signal to evaluate
     *
     * @return  array|null  [[[signal, queue], eval_return]]
     */
    public function evaluate_signals($signal)
    {
        if (count($this->_storage[self::COMPLEX_STORAGE]) == 0) {
            return null;
        }
        $return = [];
        foreach ($this->_storage[self::COMPLEX_STORAGE] as $_node) {
            $eval = $_node[0]->evaluate($signal);
            if (false !== $eval) {
                $return[] = [$_node, $eval];
            }
        }
        if (count($return) !== 0) {
            return $return;
        }
        return null;
    }

    /**
     * Loads an event for the current signal.
     * 
     * @param  int|string|object  $signal
     * @param  object  $event  \xpspl\Event
     * @param  int|null  $ttl  Event TTL
     * 
     * @return  object  \xpspl\Event
     */
    private function _event($signal, $event = null, $ttl = null)
    {
        // event creation
        if (!$event instanceof Event) {
            if (null !== $event) {
                $this->emit(new processor_signals\Invalid_Event(
                    "Invalid event passed for execution"
                ),  new processor\event\Error($event));
            }
            $event = new Event($ttl);
        } else {
            if ($event->get_state() !== STATE_DECLARED) {
                $event->set_state(STATE_RECYCLED);
            }
        }
        // keep track of the current event
        $this->_event[] = $event;
        // are we keeping the history
        if (false === $this->_history) {
            return $event;
        }
        // event history management
        if (count($this->_event) > 1)  {
            $event->set_parent($this->current_event(-1));
        }
        $this->_history[] = [$event, $signal, milliseconds()];
        return $event;
    }

    /**
     * Exits the event from the processor.
     * 
     * @param  object  $event  \xpspl\Event
     */
    private function _event_exit($event)
    {
        // event execution finished cleanup state if clean
        if ($event->get_state() === STATE_RUNNING) {
            $event->set_state(STATE_EXITED);
        }
        // are we keeping the history
        if (!$this->_history) {
            return null;
        }
        if (count($this->_event) !== 0) {
            $this->_current_event = array_pop($this->_event);
        } else {
            $this->_current_event = null;
        }
    }

    /**
     * Emits a signal.
     *
     * @param  mixed  $signal  Signal instance or signal.
     *
     * @param  object  $event  \xpspl\Event
     *
     * @return  object  Event
     */
    public function emit($signal, $event = null, $ttl = null)
    {
        // store processor signal
        $this->_signal[] = $signal;

        // load processor event
        $event = $this->_event($signal, $event, $ttl);

        // locate sig handlers
        $queue = new Queue();

        // purge exhausted queues
        if (XPSPL_PURGE_EXHAUSTED) {
            $queues = [];
        }

        // search for exact matches
        $searched = $this->search_signals($signal);
        if (null !== $searched) {
            $queue->merge($searched->storage());
            if (XPSPL_PURGE_EXHAUSTED) {
                $queues[] = $searched;
            }
        }

        // evaluate complex signals
        $evalated = $this->evaluate_signals($signal);
        if (null !== $evalated) {
            array_walk($evalated, function($node) use ($queue, $queues) {
                if (is_bool($node[1]) === false) {
                    $data = $node[1];
                    if (is_array($data)) {
                        foreach ($data as $_k => $_v) {
                            $event->{$_k} = $_v;
                        }
                    }
                }
                $queue->merge($node[0][1]->storage());
                if (XPSPL_PURGE_EXHAUSTED) {
                    $queues[] = $node[0][1];
                }
            });
        }

        // execute the signal
        $this->_execute($signal, $queue, $event);

        // purge exhausted handles
        if (XPSPL_PURGE_EXHAUSTED) {
            foreach ($queues as $_queue) {
                foreach ($_queue->storage() as $_node) {
                    if ($_node[0]->is_exhausted()) {
                        $_queue->dequeue($_node[0]);
                    }
                }
            }
        }
        // Remove the last signal
        array_pop($this->_signal);
        return $event;
    }

    /**
     * Executes a queue.
     * 
     * This will monitor the event status and break on a HALT or ERROR state.
     * 
     * Executes interruption functions before and after queue execution.
     *
     * @param  object  $signal  Signal instance.
     * @param  object  $queue  Queue instance.
     * @param  object  $event  Event instance.
     * @param  boolean  $interupt  Run the interrupt functions.
     *
     * @return  void
     */
    private function _execute($signal, $queue, $event, $interrupt = true)
    {
        if ($event->has_expired()) {
            $this->emit(new processor_signals\Event_Expired(
                "Event has expired"
            ),  new processor\event\Error([$event]));
            return $event;
        }
        // handle pre interupt functions
        if ($interrupt) {
            $this->_interrupt($signal, self::INTERRUPT_PRE, $event);
        }
        // execute the Queue
        $this->_queue_execute($queue, $event);
        // handle interupt functions
        if ($interrupt) {
            $this->_interrupt($signal, self::INTERRUPT_POST, $event);
        }
        $this->_event_exit($event);
    }

    /**
     * Executes a queue.
     *
     * If XPSPL_EXHAUSTION_PURGE is true handles will be purged once they 
     * reach exhaustion.
     *
     * @param  object  $queue  xpspl\Queue
     * @param  object  $event  xpspl\Event
     *
     * @return  void
     */
    private function _queue_execute($queue, $event)
    {
        // execute sig handlers
        $queue->sort();
        reset($queue->storage());
        foreach ($queue->storage() as $_node) {
            $_handle = $_node[0];
            # Always check state first
            if ($event->get_state() === STATE_HALTED) {
                continue;
            }
            # test for exhaustion
            if ($_handle->is_exhausted()) {
                continue;
            }
            $_handle->decrement_exhaust();
            $result = $this->_func_exec(
                $_handle->get_function(),
                $event
            );
            $event->set_result($result);
            if (false === $result) {
                $event->halt();
            }
        }
    }

    /**
     * Executes a callable processor function.
     *
     * @param  callable  $function  Function to execute
     * @param  object  $event  Event context to execute within
     * 
     * @return  boolean
     */
    private function _func_exec($function, $event)
    {
        if ($function instanceof \Closure) {
            $func = $function->bindTo($event, null);
            return $func();
        }
        if (is_array($function)) {
            if (count($function) >= 2) {
                if (is_object($function[0])) {
                    $class = $function[0];
                } else {
                    $class = new $function[0];
                }
                return $class->$function[1]($event);
            }
            return $function[0]($event);
        }
        return $function($event);
    }
    
    

    /**
     * Retrieves the signal history.
     * 
     * @return  array
     */
    public function signal_history(/* ... */)
    {
        return $this->_history;
    }

    /**
     * Sends the processor the shutdown signal.
     *
     * @return  void
     */
    public function shutdown()
    {
        $this->set_state(STATE_HALTED);
    }

    /**
     * Returns a json encoded array of the event history.
     *
     * @return  string
     */
    public function event_analysis(/* ... */)
    {
        if (!$this->_store_history) return false;
        return json_encode($this->_event_history());
    }

    /**
     * Registers a function to interrupt the signal stack before a signal fires,
     * allowing for manipulation of the event beore it is passed to handles.
     *
     * @param  string|object  $signal  Signal instance or class name
     * @param  object  $handle  Handle to execute
     * 
     * @return  boolean  True|False false is failure
     */
    public function before($signal, $handle)
    {
        return $this->_signal_interrupt($signal, $handle, self::INTERRUPT_PRE);
    }

    /**
     * Registers a function to interrupt the signal stack after a signal fires,
     * allowing for manipulation of the event after it is passed to handles.
     *
     * @param  string|object  $signal  Signal instance or class name
     * @param  object  $handle  Handle to execute
     * 
     * @return  boolean  True|False false is failure
     */
    public function after($signal, $handle)
    {
        return $this->_signal_interrupt($signal, $handle, self::INTERRUPT_POST);
    }

    /**
     * Registers a function to interrupt the signal stack before or after a 
     * signal fires.
     *
     * @param  string|object  $signal
     * @param  object  $handle  Handle to execute
     * @param  int|null  $place  Interuption location. INTERUPT_PRE|INTERUPT_POST
     * 
     * @return  boolean  True|False false is failure
     */
    protected function _signal_interrupt($signal, $handle, $interrupt = null) 
    {
        // Variable Checks
        if (!$handle instanceof Handle) {
            if (!is_callable($handle)) {
                $this->emit(new processor_signals\Invalid_Handle(
                    "Invalid handle given for signal interruption"
                ),  new processor\event\Error($handle));
                return false;
            } else {
                $handle = new Handle($handle);
            }
        }
        if (!is_object($signal) && !is_int($signal) && !is_string($signal)) {
            $this->emit(new processor_signals\Ivalid_Signal(
                "Invalid signal given for signal interruption"
            ), new processor\event\Error($signal));
            return false;
        }
        if (null === $interrupt) {
            $interrupt = self::INTERRUPT_PRE;
        }
        if ($interrupt != self::INTERRUPT_PRE && 
            $interrupt != self::INTERRUPT_POST) {
            $this->emit(new processor_signals\Invalid_Interrupt(
                "Invalid interruption location"
            ), new processor\event\Error($interrupt));
        }
        if (!isset($this->_storage[self::INTERRUPT_STORAGE][$interrupt])) {
            $this->_storage[self::INTERRUPT_STORAGE][$interrupt] = [[], []];
        }
        $storage =& $this->_storage[self::INTERRUPT_STORAGE][$interrupt];
        if ($signal instanceof signal\Complex) {
            $storage[self::COMPLEX_STORAGE][] =  [
                $signal, $handle
            ];
        } else {
            if ($signal instanceof Signal) {
                $name = $signal->get_info();
            } else {
                if (is_object($signal)) {
                    $name = get_class($signal);
                } else {
                    $name = $signal;
                }
            }
            if (!isset($storage[self::HASH_STORAGE][$name])) {
                $storage[self::HASH_STORAGE][$name] = [];
            }
            $storage[self::HASH_STORAGE][$name][] = [
                $signal, $handle
            ];
        }
        return true;
    }

    /**
     * Handle signal interuption functions.
     * 
     * @param  object  $signal  Signal
     * @param  int  $interupt  Interupt type
     * 
     * @return  boolean
     */
    private function _interrupt($signal, $type, $event)
    {
        // do nothing no interrupts registered
        if (!isset($this->_storage[self::INTERRUPT_STORAGE][$type])) {
            return true;
        }
        $queue = null;
        if (count($this->_storage[self::INTERRUPT_STORAGE][$type][self::COMPLEX_STORAGE]) != 0) {
            foreach ($this->_storage[self::INTERRUPT_STORAGE][$type][self::COMPLEX_STORAGE] as $_node) {
                $eval = $_node[0]->evaluate($signal);
                if (false !== $eval) {
                    if (true !== $eval) {
                        if (is_array($eval)) {
                            foreach ($eval as $_k => $_v) {
                                $event->{$_k} = $_v;
                            }
                        }
                    }
                    if (null === $queue) {
                        $queue = new Queue();
                    }
                    if (!$_node[1]->is_exhausted()) {
                        $queue->enqueue($_node[1], $_node[1]->get_priority());
                    }
                }
            }
        }
        $lookup = [];
        $class_name = (is_object($signal)) ? get_class($signal) : $signal;
        if ($signal instanceof Signal) {
            $info = $signal->get_info();
            if ($info != $class_name) {
                $lookup[] = $info;
            }
        } else {
            $lookup[] = $class_name;
        }
        foreach ($lookup as $_index) {
            if (isset($this->_storage[self::INTERRUPT_STORAGE][$type][self::HASH_STORAGE][$_index])) {
                foreach ($this->_storage[self::INTERRUPT_STORAGE][$type][self::HASH_STORAGE][$_index] as $_node) {
                    if (null === $queue) {
                        $queue = new Queue();
                    }
                    if (!$_node[1]->is_exhausted()) {
                        $queue->enqueue($_node[1], $_node[1]->get_priority());
                    }
                }
            }
        }
        if (null !== $queue) {
            $this->_queue_execute($queue, $event);
        }
    }

    /**
     * Cleans any exhausted signals from the processor.
     * 
     * @param  boolean  $history  Erase any history of the signals cleaned.
     * 
     * @return  void
     */
    public function clean($history = false)
    {
        $storages = [
            self::HASH_STORAGE, self::COMPLEX_STORAGE, self::INTERRUPT_STORAGE
        ];
        foreach ($storages as $_storage) {
            if (count($this->_storage[$_storage]) == 0) continue;
            foreach ($this->_storage[$_storage] as $_index => $_node) {
                if ($_node[1] instanceof Handle && $_node[1]->is_exhausted() ||
                    $_node[1] instanceof Queue && $this->queue_exhausted($_node[1])) {
                    unset($this->_storage[$_storage][$_index]);
                    if ($history) {
                        $this->erase_signal_history(
                            ($_node[0] instanceof signal\Complex) ?
                                $_node[0] : $_node[0]->get_info()
                        );
                    }
                }
            }
        }
    }

    /**
     * Delete a signal from the processor.
     * 
     * @param  string|object|int  $signal  Signal to delete.
     * @param  boolean  $history  Erase any history of the signal.
     * 
     * @return  boolean
     */
    public function delete_signal($signal, $history = false)
    {
        $info = false;
        if ($signal instanceof signal\Standard) {
            if ($signal instanceof signal\Complex) {
                $obj = spl_object_hash($signal);
                if (!isset($this->_storage[self::COMPLEX_STORAGE][$obj])) {
                    return false;
                }
                unset($this->_storage[self::COMPLEX_STORAGE][$obj]);
            } else {
                $info = $signal->get_info();
            }
        } else {
            if (!is_string($signal) && !is_int($signal)) {
                $this->emit(new processor_signals\Invalid_Signal(
                    "Delete signal"
                ), new processor\event\Error($signal));
                return false;
            }
            $info = $signal;
        }

        if (false !== $info) {
            if (!isset($this->_storage[self::HASH_STORAGE][$info])) {
                return false;
            }
            unset($this->_storage[self::HASH_STORAGE][$info]);
        }

        if ($history) {
            $this->erase_signal_history($signal);
        }
        return true;
    }

    /**
     * Erases any history of a signal.
     * 
     * @param  string|object  $signal  Signal to be erased from history.
     * 
     * @return  void
     */
    public function erase_signal_history($signal)
    {
        if (!$this->_history) {
            return false;
        }
        // recursivly check if any events are a child of the given signal
        // because if the chicken doesn't exist neither does the egg ...
        // or does it?
        $descend_destory = function($_event, $_signal) use ($signal, &$descend_destory) {
            // child and not a child of itself
            if ($_event->is_child() && $_event->get_parent() !== $_event) {
                return $descend_destory($_event->get_parent(), $_signal);
            }
            if ($_signal === $signal) {
                return true;
            }
        };
        foreach ($this->_history as $_key => $_node) {
            if ($_node[1] === $signal) {
                unset($this->_history[$_key]);
            } elseif ($_node[0]->is_child() && $_node[0]->get_parent() !== $_node[0]) {
                if ($descend_destory($_node[0]->get_parent(), $_node[1])) {
                    unset($this->_history[$_key]);
                }
            }
        }
    }

    /**
     * Sets the flag for storing the event history.
     *
     * Note that this will delete the current if reset.
     *
     * @param  boolean  $flag
     *
     * @return  void
     */
    public function save_signal_history($flag)
    {
        if ($flag === true) {
            if (!$this->_history) {
                $this->_history = [];
            }
            return;
        }
        $this->_history = false;
    }

    /**
     * Returns the current signal in execution.
     *
     * @param  integer  $offset  In memory hierarchy offset +/-.
     *
     * @return  object
     */
    public function current_signal($offset = 1)
    {
        $count = count($this->_signal);
        if ($count === 0) {
            return null;
        }
        if ($count === 1) {
            return $this->_signal[0];
        }
        return array_slice($this->_signal, $offset, 1)[0];
    }

    /**
     * Returns the current event.
     *
     * @param  integer  $offset  In memory hierarchy offset +/-.
     *
     * @return  object  \xpspl\Event
     */
    public function current_event($offset = 0)
    {
        $count = count($this->_event);
        if ($count === 0) {
            return null;
        }
        if ($count === 1) {
            return $this->_event[0];
        }
        return array_slice($this->_event, $offset, 1)[0];
    }
}