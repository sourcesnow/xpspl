<?php
namespace prggmr\signal;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Routine signal class
 * 
 * This is the object returned to the engine after a routine calculation is run,
 * to allow the engine to determine idle time, signals to dispatch or an
 * idle function.
 */
final class Routine {

    /**
     * Amount of time to idle the engine in seconds.
     *
     * @var  integer|null
     */
    protected $_idle_seconds = null;

    /**
     * Amount of time to idle the engine in milliseconds.
     *
     * @var  integer|null
     */
    protected $_idle_milliseconds = null;

    /**
     * Amount of time to idle the engine in microseconds.
     *
     * @var  integer|null
     */
    protected $_idle_microseconds = null;

    /**
     * Array of signals to dispatch.
     *
     * @var  array|null
     */
    protected $_signals = [];

    /**
     * Function to execute to idle the engine.
     *
     * @var  closure|null
     */
    protected $_idle_function = null;

    /**
     * Registers a new signal to trigger.
     *
     * @param  int|string|object  $signal  Signal to trigger.
     * @param  object|null  $event  Event to use during execution.
     * @param  null|array  $vars  Variables to pass the sig handler.
     * 
     * @return  boolean
     */
    public function add_signal($signal = null, $event = null, $vars = null) 
    {
        $this->_signals[] = [$signal, $vars, $event];
    }


    /**
     * Returns the signals registered.
     *
     * @return  array|null
     */
    public function get_signals()
    {
        return $this->_signals;
    }

    /**
     * Returns an idle time for the signal in seconds.
     *
     * @return  integer|null
     */
    public function get_idle_seconds(/* ... */)
    {
        return $this->_idle_seconds;
    }

    /**
     * Returns an idle time for the signal in seconds.
     *
     * @return  integer|null
     */
    public function get_idle_milliseconds(/* ... */)
    {
        return $this->_idle_milliseconds;
    }

    /**
     * Returns an idle time for the signal in microseconds.
     *
     * @return  integer|null
     */
    public function get_idle_microseconds(/* ... */)
    {
        return $this->_idle_microseconds;
    }

    /**
     * Returns an idle time for the signal in seconds.
     *
     * @return  integer|null
     */
    public function get_idle_seconds(/* ... */)
    {
        return $this->_idle_seconds;
            $this->_idle_milliseconds,
            $this->_idle_microseconds
        ];
    }

    /**
     * Returns a function for the engine to run during idle.
     *
     * @return  null|closure
     */
    public function get_idle_function(/* ... */)
    {
        return $this->_idle_function;
    }

    /**
     * Sets the time to idle in seconds.
     *
     * @return  void
     */
    public function set_idle_seconds($time)
    {
        $this->_idle_seconds = $time;
    }

    /**
     * Sets the time to idle in seconds.
     *
     * @throws  OverflowException
     * 
     * @return  void
     */
    public function set_idle_milliseconds($time)
    {
        $this->_idle_milliseconds = $time * 1000;
    }

    /**
     * Sets the time to idle in microseconds.
     *
     * @throws  OverflowException
     * 
     * @return  void
     */
    public function set_idle_microseconds($time)
    {
        $this->_idle_microseconds = $time;
    }

    /**
     * Sets a function for the engine to run during idle.
     *
     * @param  closure  $function  Function to run to idle.
     * 
     * @return  void
     */
    public function set_idle_function($function)
    {
        $this->_idle_function = $function;
    }

    /**
     * Resets the routine after the engine has used it.
     *
     * @return  void
     */
    public function reset()
    {
        $this->_idle_function = null;
        $this->_idle_time = null;
        $this->_signals = null;
    }
}