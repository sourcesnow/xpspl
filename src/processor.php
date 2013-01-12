<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \Closure,
    \InvalidArgumentException,
    \XPSPL\processor\exception as exceptions;

/**
 * Processor
 *
 * The brainpower of XPSPL.
 * 
 * @since v0.3.0 
 * 
 * The loop is now run in respect to the currently available processs,
 * this prevents the processor from running contionusly forever when there isn't anything
 * that it needs to do.
 *
 * To achieve this the processor uses routines for calculating when to run and 
 * shutdowns when no more are available.
 *
 * The queue storage has also been improved by using only a single array.
 */
class Processor {

    /**
     * Stateful and storage object
     */
    use State;

    /**
     * SIG storage array.
     *
     * @var  array
     */
    private $_sig_index = [];
    /**
     * SIG_Complex storage array.
     *
     * @var  array
     */
    private $_sig_complex = [];
    /**
     * SIG_Routine storage array.
     * 
     * @var  array
     */
    private $_sig_routine = [];
    /**
     * Interruption storage.
     *
     * @var  array
     */
    private $_int_storage = [];
    /**
     * Interruption before emittion
     *
     * @var  integer
     */
    const INTERRUPT_PRE = 0;
    /**
     * Interruption after emittion
     *
     * @var  integer
     */
    const INTERRUPT_POST = 1;
    /**
     * Signal history.
     * 
     * @var  boolean|array
     */
    protected $_history = false;

    /**
     * Currently executing signal and hierachy
     */
    private $_signal = [];

    /**
     * Starts the processor.
     *
     * @return  void
     */
    public function __construct()
    {
        $this->set_state(STATE_DECLARED);
        $this->flush(); 
    }

    /**
     * Cleans out the signal history.
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
                new \XPSPL\time\SIG_Awake($ttr, TIME_MILLISECONDS), 
                $awake_func
            );
        }
        $this->emit(new processor\SIG_Startup());
        for($this->_routine();;) {
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
        $routine = new Routine();
        // allow for external shutdown signal before running anything
        if ($this->get_state() === STATE_HALTED) return false;
        // run the routines
        foreach ($this->_sig_routine as $_key => $_node) {
            $_node[0]->routine($routine, $this->_history);
        }
        // Check signals
        if (count($routine->get_signals()) != 0) {
            // This checks only for one possible signal that has not exhausted
            // it still leaves the possibility for triggering exhausted signals
            foreach ($routine->get_signals() as $_signal) {
                if (false === $this->has_signal_exhausted($_signal[0])) {
                    return true;
                }
            }
        }
        // Check idle
        if (null !== $routine->get_idle()) {
            return true;
        }
        return false;
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
     * Determine if all queue processs are exhausted.
     *
     * @param  object  $queue  \XPSPL\Queue
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
            // if a non exhausted process is found return false
            if (!$queue->current()[0]->is_exhausted()) {
                return false;
            }
            $queue->next();
        }
        return true;
    }

    /**
     * Removes a signal process.
     *
     * @param  mixed  $signal  Signal instance or signal.
     * @param  mixed  $process  Process instance or identifier.
     * 
     * @return  void
     */
    public function remove_process($signal, $process)
    {
        $queue = $this->search_signals($signal);
        if (null === $queue) {
            return;
        }
        return $queue->dequeue($process);
    }

    /**
     * Empties the storage, history and clears the current state.
     *
     * @return void
     */
    public function flush(/* ... */)
    {
        foreach (['_sig_index', '_sig_complex', '_sig_routine'] as $_i) {
            $this->{$_i} = [];
        }
        $this->_routine = new Routine();
        if (false !== $this->_history){
            $this->_history = [];
        }
    }

    /**
     * Registers an object listener.
     *
     * @param  object  $listener  XPSPL\Listener
     *
     * @return  void
     */
    public function listen(Listener $listener)
    {
        foreach ($listener->_get_signals() as $_signal) {
            $this->signal($_signal, [$listener, $_signal]);
        }
        $listener->_reset();
    }

    /**
     * Creates a new signal process.
     *
     * @param  string|int|object  $signal  Signal to attach the process.
     * @param  object  $callable  Signal process
     *
     * @return  object|boolean  Process, boolean if error
     */
    public function signal($signal, $process)
    {
        if (!$process instanceof Process) {
            if (!is_callable($process)) {
                $this->emit(new exceptions\Invalid_Process(
                       "Invalid process given to install" 
                    ), new processor\event\Error([func_get_args()])
                );
                return false;
            }
            $process = new Process($process);
        }
        $queue = $this->register_signal($signal);
        if (false !== $queue) {
            if (is_array($queue)) {
                $queue = $queue[0][0];
            }
            $queue->enqueue($process, $process->get_priority());
        }
        return $process;
    }

    /**
     * Registers a signal into the processor
     *
     * @param  string|integer|object  $signal  Signal
     *
     * @return  boolean|object  false|XPSPL\Queue
     */
    public function register_signal($signal)
    {
        $queue = false;

        if (!$signal instanceof \XPSPL\signal\Standard) {
            try {
                $signal = new Signal($signal);
            } catch (\InvalidArgumentException $e) {
                throw new exceptions\Invalid_Signal(
                    "Invalid signal given to register"
                );
                return false;
            }
        }

        $search = $this->search_signals($signal);

        if (null !== $search) {
            return $search;
        }

        if (!$queue) {
            $queue = new Queue();
            if (!$signal instanceof SIG_Complex) {
                $this->_sig_index[(string) $signal->get_index()] = [
                    $signal, $queue
                ];
            } else {
                $id = spl_object_hash($signal);
                $this->_sig_complex[$id] = [$signal, $queue];
            }
        }
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
        if ($signal instanceof SIG_Complex) {
            $id = spl_object_hash($signal);
            if (isset($this->_sig_complex[$id])) {
                if ($index) return $id;
                return $this->_sig_complex[$id][1];
            }
            return null;
        }
        if ($signal instanceof SIG) {
            $signal = $signal->get_index();
        }
        $signal = (string) $signal;
        if (isset($this->_sig_index[$signal])) {
            if ($index) return $signal;
            return $this->_sig_index[$signal][1];
        }
        return null;
    }

    /**
     * Perform the evaluation for all registered complex signals.
     *
     * @param  string|object|int  $signal  Signal to evaluate
     *
     * @return  array|null  [[[signal, queue], eval_return]]
     */
    public function evaluate_signals($signal)
    {
        if (count($this->_sig_complex) == 0) {
            return null;
        }
        $return = [];
        foreach ($this->_sig_complex as $_node) {
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
     * @param  object  $event  \XPSPL\Event
     * @param  int|null  $ttl  Event TTL
     * 
     * @return  object  \XPSPL\Event
     */
    private function _event($signal, $event = null, $ttl = null)
    {
        // event creation
        if (!$event instanceof Event) {
            if (null !== $event) {
                throw new exceptions\Invalid_Event(
                    "Invalid event passed for execution"
                );
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
     * @param  object  $event  \XPSPL\Event
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
     * @param  object|null  $context  Context to execute
     *
     * @return  object  Event
     */
    public function emit($signal, $context = null)
    {
        // store processor signal
        $this->_signal[] = $signal;
        $queue = null;

        // Store the history of the signal
        if (false !== $this->_history) {
            $this->_history[] = [$signal, milliseconds()];
        }

        // Signal history management
        if (count($this->_signal) > 1)  {
            $signal->set_parent($this->current_signal(-1));
        }

        // purge exhausted queues
        if (XPSPL_PURGE_EXHAUSTED) {
            $queues = [];
        }

        // search for index signal
        $searched = $this->search_signals($signal);
        if (null !== $searched) {
            if (null === $queue) {
                $queue = new Queue();
            }
            $queue->merge($searched->storage());
            if (XPSPL_PURGE_EXHAUSTED) {
                $queues[] = $searched;
            }
        }

        // evaluate complex signals
        $evalated = $this->evaluate_signals($signal);
        if (null !== $evalated) {
            if (null === $queue) {
                $queue = new Queue();
            }
            array_walk($evalated, function($node) use ($queue, $queues) {
                if (is_bool($node[1]) === false) {
                    $data = $node[1];
                    if (is_array($data)) {
                        foreach ($data as $_k => $_v) {
                            $signal->{$_k} = $_v;
                        }
                    }
                }
                $queue->merge($node[0][1]->storage());
                if (XPSPL_PURGE_EXHAUSTED) {
                    $queues[] = $node[0][1];
                }
            });
        }

        // run the execution
        if (null !== $queue && $queue->count() >= 0) {
            // execute the signal
            $this->_execute((null === $context) ? $signal : $context, $queue);
            // purge exhausted processs
            if (XPSPL_PURGE_EXHAUSTED) {
                foreach ($queues as $_queue) {
                    foreach ($_queue->storage() as $_node) {
                        if ($_node[0]->is_exhausted()) {
                            $_queue->dequeue($_node[0]);
                        }
                    }
                }
            }
        }

        // Remove the last signal
        array_pop($this->_signal);
        return $signal;
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
    private function _execute($signal, $queue, $interrupt = true)
    {
        // process pre interupt functions
        if ($interrupt) {
            $this->_interrupt($signal, self::INTERRUPT_PRE);
        }
        // execute the Queue
        $this->_queue_execute($queue, $signal);
        // process interupt functions
        if ($interrupt) {
            $this->_interrupt($signal, self::INTERRUPT_POST);
        }
    }

    /**
     * Executes a queue.
     *
     * If XPSPL_EXHAUSTION_PURGE is true processs will be purged once they 
     * reach exhaustion.
     *
     * @param  object  $queue  XPSPL\Queue
     * @param  object  $signal  XPSPL\Signal
     *
     * @return  void
     */
    private function _queue_execute($queue, $signal)
    {
        // execute sig processs
        $queue->sort();
        reset($queue->storage());
        $result = null;
        foreach ($queue->storage() as $_node) {
            $_process = $_node[0];
            # Always check state first
            if ($signal->get_state() === STATE_HALTED) {
                break;
            }
            # test for exhaustion
            if ($_process->is_exhausted()) {
                continue;
            }
            $_process->decrement_exhaust();
            $result = $this->_func_exec(
                $_process->get_function(),
                $signal
            );
            if (false === $result) {
                $signal->halt();
                break;
            }
        }
        $signal->set_result($result);
    }

    /**
     * Executes a callable processor function.
     *
     * @param  callable  $function  Function to execute
     * @param  object  $signal  Signal context to execute within
     * 
     * @return  boolean
     */
    private function _func_exec($function, $signal)
    {
        if ($function instanceof \Closure) {
            $func = $function->bindTo($signal, null);
            return $func();
        }
        if (is_array($function)) {
            if (count($function) >= 2) {
                if (is_object($function[0])) {
                    $class = $function[0];
                } else {
                    $class = new $function[0];
                }
                return $class->$function[1]($signal);
            }
            return $function[0]($signal);
        }
        if ($function === null) {
            debug_print_backtrace();
            exit(0);
        }
        return $function($signal);
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
     * Registers a function to interrupt the signal stack before a signal emits,
     * allowing for manipulation of the signal before it is passed to processs.
     *
     * @param  string|object  $signal  Signal instance or class name
     * @param  object  $process  Process to execute
     * 
     * @return  boolean  True|False false is failure
     */
    public function before($signal, $process)
    {
        return $this->_signal_interrupt($signal, $process, self::INTERRUPT_PRE);
    }

    /**
     * Registers a function to interrupt the signal stack after a signal emits,
     * allowing for manipulation of the signal after it is passed to processs.
     *
     * @param  string|object  $signal  Signal instance or class name
     * @param  object  $process  Process to execute
     * 
     * @return  boolean  True|False false is failure
     */
    public function after($signal, $process)
    {
        return $this->_signal_interrupt($signal, $process, self::INTERRUPT_POST);
    }

    /**
     * Registers a function to interrupt the signal stack before or after a 
     * signal emits.
     *
     * @param  string|object  $signal
     * @param  object  $process  Process to execute
     * @param  int|null  $place  Interuption location. INTERUPT_PRE|INTERUPT_POST
     * 
     * @return  boolean  True|False false is failure
     */
    protected function _signal_interrupt($signal, $process, $interrupt = null) 
    {
        // Variable Checks
        if (!$process instanceof Process) {
            if (!is_callable($process)) {
                throw new exceptions\Invalid_Process(
                    "Invalid process given for signal interruption"
                );
            } else {
                $process = new Process($process);
            }
        }
        if (!is_object($signal) && !is_int($signal) && !is_string($signal)) {
            throw new exceptions\Ivalid_Signal(
                "Invalid signal given for signal interruption"
            );
            return false;
        }
        if (null === $interrupt) {
            $interrupt = self::INTERRUPT_PRE;
        }
        if ($interrupt != self::INTERRUPT_PRE && 
            $interrupt != self::INTERRUPT_POST) {
            throw new exceptions\Invalid_Interrupt(
                "Invalid Interruption Step"
            );
        }
        if (!isset($this->_storage[self::INTERRUPT_STORAGE][$interrupt])) {
            $this->_storage[self::INTERRUPT_STORAGE][$interrupt] = [[], []];
        }
        $storage =& $this->_storage[self::INTERRUPT_STORAGE][$interrupt];
        if ($signal instanceof signal\Complex) {
            $storage[self::COMPLEX_STORAGE][] =  [
                $signal, $process
            ];
        } else {
            if ($signal instanceof Signal) {
                $name = $signal->get_index();
            } else {
                if (is_object($signal)) {
                    $name = get_class($signal);
                } else {
                    $name = $signal;
                }
            }
            if (!isset($storage[self::SIG_STORAGE][$name])) {
                $storage[self::SIG_STORAGE][$name] = [];
            }
            $storage[self::SIG_STORAGE][$name][] = [
                $signal, $process
            ];
        }
        return true;
    }

    /**
     * Process signal interuption functions.
     * 
     * @param  object  $signal  Signal
     * @param  int  $interupt  Interupt type
     * 
     * @return  boolean
     */
    private function _interrupt($signal, $type)
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
            $info = $signal->get_index();
            if ($info != $class_name) {
                $lookup[] = $info;
            }
        } else {
            $lookup[] = $class_name;
        }
        foreach ($lookup as $_index) {
            if (isset($this->_storage[self::INTERRUPT_STORAGE][$type][self::SIG_STORAGE][$_index])) {
                foreach ($this->_storage[self::INTERRUPT_STORAGE][$type][self::SIG_STORAGE][$_index] as $_node) {
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
            $this->_queue_execute($queue, $signal);
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
            self::SIG_STORAGE, self::COMPLEX_STORAGE, self::INTERRUPT_STORAGE
        ];
        foreach ($storages as $_storage) {
            if (count($this->_storage[$_storage]) == 0) continue;
            foreach ($this->_storage[$_storage] as $_index => $_node) {
                if ($_node[1] instanceof Process && $_node[1]->is_exhausted() ||
                    $_node[1] instanceof Queue && $this->queue_exhausted($_node[1])) {
                    unset($this->_storage[$_storage][$_index]);
                    if ($history) {
                        $this->erase_signal_history(
                            ($_node[0] instanceof signal\Complex) ?
                                $_node[0] : $_node[0]->get_index()
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
        $index = false;
        if ($signal instanceof signal\Standard) {
            if ($signal instanceof signal\Complex) {
                $obj = spl_object_hash($signal);
                if (!isset($this->_sig_complex[$obj])) {
                    return false;
                }
                unset($this->_sig_complex[$obj]);
            } else {
                $index = $signal->get_index();
            }
        } else {
            if (!is_string($signal) && !is_int($signal)) {
                throw new exceptions\Invalid_Signal(
                    "Delete signal"
                );
                return false;
            }
            $index = $signal;
        }

        if (false !== $index) {
            if (!isset($this->_sig_index[$index])) {
                return false;
            }
            unset($this->_sig_index[$index]);
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
}