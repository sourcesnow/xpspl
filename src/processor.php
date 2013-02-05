<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\processor\exception as exceptions;

/**
 * Processor
 *
 * The brainpower of XPSPL.
 * 
 * @since v0.3.0 
 * 
 * The loop is now run in respect to the currently available processes,
 * this prevents the processor from running contionusly forever when there is not
 * anything that it needs to do.
 *
 * To achieve this the processor uses routines.
 *
 * @since v3.0.0
 *
 * Signal storages have been upgraded to a database object, the routine and 
 * evaluation methods for the complex signal have also been moved into their 
 * own classes.
 *
 * The loop has been replaced with a goto statement, measurements indicate that 
 * it performs faster than a loop ... though should it? 
 */
class Processor {

    /**
     * Stateful and storage object
     */
    use State;

    /**
     * SIG storage database.
     *
     * @var  array
     */
    private $_sig_index = null;
    /**
     * SIG_Complex storage database.
     *
     * @var  array
     */
    private $_sig_complex = null;
    /**
     * SIG_Routine storage database.
     * 
     * @var  array
     */
    private $_sig_routine = null;
    /**
     * Interruption before execution storage.
     *
     * @var  array
     */
    private $_int_before = null;
    /**
     * Interruption before execution storage.
     *
     * @var  array
     */
    private $_int_after = null;
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
     * Analyzes the processor runtime and shutdowns when no activity is 
     * detected.
     *
     * @param  object  $sig_awake  SIG_Awake
     *
     * @return  void
     */
    public function anaylze_runtime(SIG_Awake $sig_awake)
    {
        if (!isset($sig_awake->analysis)) {
            $sig_awake->analysis = microseconds();
            $sig_awake->count = 0;
        } else {
            if (0 === ($sig_awake - microseconds()) >> 10) {
                if ($sig_awake->count > 5) {
                    $this->shutdown();
                }
                $sig_awake->count = $sig_awake->count + 1;
            } else {
                $sig_awake->count = 0;
            }
            $sig_awake->analysis = microseconds();
        }
    }

    /**
     * Waits for the next signal to occur.
     *
     * @todo unittest
     * 
     * @return  void
     */
    public function wait_loop()
    {
        /**
         * The original method found in the loop has been replaced
         * with an intelligent time based analysis.
         */
        $this->emit(new processor\SIG_Startup());
        if (class_exists('time\\SIG_Awake', true)) {
            $this->signal(
                new \time\SIG_Awake(35, TIME_MICROSECONDS), 
                new Process([$this, 'analyze_runtime'], null, 0)
            );
        }
        routine:
        if ($this->_routine()) {
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
            goto routine;
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
        // allow for external shutdown signal before running anything
        if ($this->get_state() === STATE_HALTED) return false;
        // run the routines
        foreach ($this->_sig_routine->storage() as $_routine) {
            $_routine[0]->routine($this->_routine);
        }
        // Check signals
        if (count($this->_routine->get_signals()) != 0) {
            // This checks only for one possible signal that has not exhausted
            // it still leaves the possibility for triggering exhausted signals
            foreach ($this->_routine->get_signals() as $_signal) {
                if (false === $this->has_signal_exhausted($_signal[0])) {
                    return true;
                }
            }
        }
        // Check idle
        if (null !== $this->_routine->get_idle()) {
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
    public function has_signal_exhausted(SIG $signal)
    {
        $memory = $this->find_signal($signal);
        if (null === $memory || $memory[1]->count() === 0) {
            return true;
        }
        return true === $this->queue_exhausted($memory[1]);
    }

    /**
     * Determine if all queue processs are exhausted.
     *
     * @param  object  $queue  \XPSPL\database\Queue
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
        $queue = $this->find_signal($signal);
        if (null === $queue) {
            return;
        }
        return $queue->dequeue($process);
    }

    /**
     * Flush
     *
     * Resets the signal databases, the routine object and cleans the history 
     * if tracked.
     *
     * @return void
     */
    public function flush(/* ... */)
    {
        // Databases to flush
        $database = [
            '_sig_index', 
            '_sig_complex',
            '_sig_routine',
            '_int_before', 
            '_int_after'
        ];
        foreach ($database as $_db) {
            if (is_object($this->{$_db})) {
                if (XPSPL_DEBUG) {
                    import('unittest');
                    \unittest\Output::send(sprintf(
                        '%s - Flush'.PHP_EOL.
                        '%i - Mem Start'.PHP_EOL,
                        $_db,
                        $this->{$_db}->storage()->memoryUsage()
                    ));
                }
                $this->{$_db}->free();
                if (XPSPL_DEBUG) {
                    import('unittest');
                    \unittest\Output::send(sprintf(
                        '%i - Mem Finish'.PHP_EOL,
                        $this->{$_db}->storage()->memoryUsage()
                    ));
                }
            } else {
                $this->{$_db} = new Database();
            }
        }
        if (is_object($this->_routine)){
            $this->_routine->reset();
        } else {
            $this->_routine = new Routine();
        }
        if (false !== $this->_history){
            $this->_history = [];
        }
    }

    /**
     * Listen
     * 
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
    public function signal(SIG $signal, Process $process)
    {
        if (!$signal instanceof SIG) {
            $signal = new SIG($signal);
        }
        if (!$process instanceof Process) {
            $process = new Process($process);
        }
        $memory = $this->find_signal($signal);
        if (null === $memory) {
            $queue = $this->register_signal($signal);
        } else {
            $queue = $memory[1];
        }
        $queue->enqueue($process, $process->get_priority());
        return $process;
    }

    /**
     * Registers a signal into the processor.
     *
     * @param  string|integer|object  $signal  Signal
     *
     * @return  boolean|object  false|XPSPL\Queue
     */
    public function register_signal(SIG $signal)
    {
        if (!$signal instanceof SIG) {
            $signal = new SIG($signal);
        }
        $queue = new \XPSPL\database\Queue();
        $db = $this->get_database($signal);
        $db->register_signal($signal, $queue);
        return $queue;
    }

    /**
     * Returns the signal database for the given signal.
     *
     * @param  object  $signal
     * 
     * @return  array
     */
    public function get_database(SIG $signal)
    {
        if ($signal instanceof SIG_Complex) {
            return $this->_sig_complex;
        }
        if ($signal instanceof SIG_Routine) {
            return $this->_sig_routine;
        }
        if ($signal instanceof SIG) {
            return $this->_sig_index;
        }
    }

    /**
     * Finds an installed signal.
     *
     * @param  object  $signal  SIG
     * 
     * @return  object  \XPSPL\Queue
     */
    private function find_signal(SIG $signal)
    {
        $db = $this->get_database($signal);
        $memory = $db->find_signal($signal);
        if (null !== $memory) {
            return $memory;
        }
    }

    /**
     * Perform the evaluation for all registered complex signals.
     *
     * @param  string|object|int  $signal  Signal to evaluate
     *
     * @return  array|null  [[[signal, queue], eval_return]]
     */
    public function evaluate_signals(SIG $signal)
    {
        if ($this->_sig_complex->count() == 0) {
            return null;
        }
        $signals = [];
        foreach ($this->_sig_complex->storage() as $_node) {
            $eval = $_node[0]->evaluate($signal);
            if (false !== $eval) {
                $signals[] = $_node[1];
            }
        }
        if (count($signals) !== 0) {
            return $signals;
        }
        return null;
    }

    /**
     * Emits a signal.
     *
     * @param  mixed  $signal  Signal instance or signal.
     * @param  object|null  $context  Context to execute
     *
     * @return  object  Event
     */
    public function emit(SIG $signal, $context = null)
    {
        if (!$signal instanceof SIG) {
            $signal = new SIG($signal);
        }
        // Store the history of the signal
        if (false !== $this->_history) {
            $this->_history[] = [$signal, microtime()];
        }
        // Set child status
        if (count($this->_signal) > 1)  {
            $signal->set_parent($this->current_signal());
        }
        // Check if signal is installed
        $memory = $this->find_signal($signal);
        if (null === $memory) {
            return $signal;
        }
        // Set as currently emitted signal
        $this->_signal[] = $signal;
        // The queues to execute and later purge
        $queues = [$memory[1]];
        // evaluate complex signals
        $evaluated = $this->evaluate_signals($signal);
        if (null !== $evaluated) {
            $queues = array_merge($queues, $evaluated);
        }
        // run the execution
        $queue = new Queue();
        foreach ($queues as $_queue) {
            $queue->merge($_queue->storage());
        }
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
     * @param  boolean  $interupt  Run the interrupt functions.
     *
     * @return  void
     */
    private function _execute(SIG $signal, Queue $queue, $interrupt = true)
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
    private function _queue_execute(Queue $queue, SIG $signal)
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
            $result = $this->_process_exec(
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
    private function _process_exec(Process $function, SIG $signal)
    {
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
            throw new exceptions\Invalid_Process(sprintf(
                'Signal (%s) encountered a null process during execution',
                $signal->get_index()
            ));
        }
        return $function($signal);
    }
    
    /**
     * Returns the signal history.
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
     * Registers a function to interrupt the signal stack before a signal emits.
     * 
     * This allows for manipulation of the signal before it is passed to any 
     * processes.
     *
     * @param  string|object  $signal  Signal instance or class name
     * @param  object  $process  Process to execute
     * 
     * @return  boolean  True|False false is failure
     */
    public function before($signal, $process)
    {
        return $this->_signal_interrupt($signal, $process, Processor::INTERRUPT_PRE);
    }

    /**
     * Registers a function to interrupt the signal stack after a signal emits.
     * 
     * This allows for analysis of a signal after execution in processes.
     *
     * @param  string|object  $signal  Signal instance or class name
     * @param  object  $process  Process to execute
     * 
     * @return  boolean  True|False false is failure
     */
    public function after($signal, $process)
    {
        return $this->_signal_interrupt($signal, $process, Processor::INTERRUPT_POST);
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
        if (!$signal instanceof SIG) {
            $sig = new SIG($signal);
        }
        if (!$process instanceof Process) {
            $process = new Process($process);
        }
        $memory = $this->find_signal($signal);
        if (null === $signal) {
            throw new exceptions\Unregistered_Signal(sprintf(
                'Signal %s must be registered before installing interruptions',
                (is_object($signal)) ? get_class($signal) : $signal
            ));
        }
        $database = $this->_get_int_database($interrupt);
        $memory = $database->find_signal($signal);
        if (null === $memory) {
            $queue = new Queue();
            $database->register_signal($signal, $queue);
        } else {
            $queue = $memory[1];
        }
        $queue->enqueue($process);
        return true;
    }

    /**
     * Returns the interruption storage database.
     * 
     * @param  integer  $type  The interruption type
     * 
     * @return  object  \XPSPL\Database
     *
     * @since  v4.0.0
     */
    private function _get_int_database($interrupt)
    {
        if (Processor::INTERRUPT_PRE === $interrupt) {
            return $this->_int_before;
        }
        if (Processor::INTERRUPT_POST === $interrupt) {
            return $this->_int_after;
        }
        throw new LogicException("Unknown interruption $interrupt");
    }

    /**
     * Process signal interuption functions.
     * 
     * @param  object  $signal  Signal
     * @param  int  $interupt  Interupt type
     * 
     * @return  boolean
     */
    private function _interrupt(SIG $signal, $interrupt = null)
    {
        $database = $this->_get_int_database($interrupt);
        $memory = $database->find_signal($signal);
        if (null === $memory) {
            return;
        }
        $this->_queue_execute($memory[1], $signal);
    }

    /**
     * Cleans any exhausted signals from the processor.
     * 
     * @param  boolean  $history  Erase any history of the signals cleaned.
     * 
     * @return  void
     *
     * @todo
     *
     * Clean this ugly code ... 
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
        // recursivly check if any signals are a child of the given signal
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
     * Sets the flag for storing the signal history.
     *
     * Note that this will delete the current if reset.
     *
     * @param  boolean  $flag
     *
     * @return  void
     */
    public function set_signal_history($flag)
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