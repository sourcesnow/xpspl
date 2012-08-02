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
     * Array of signals to dispatch.
     *
     * @var  array|null
     */
    protected $_signals = [];

    /**
     * Idler used to idle the engine.
     *
     * @var  object|null
     */
    protected $_idle = null;

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
     * Returns an idle for the engine.
     *
     * @return  object|null
     */
    public function get_idle(/* ... */)
    {
        return $this->_idle;
    }

    /**
     * Sets the time to idle in seconds.
     *
     * @return  void
     */
    public function set_idle($idle)
    {
        if (!$idle instanceof \prggmr\engine\Idle) {
            throw new \InvalidArgumentException(
                "Idle must be an instance of prggmr\engine\Idle"
            );
        }
        $this->_idle = $idle;
    }

    /**
     * Resets the routine after the engine has used it.
     *
     * @return  void
     */
    public function reset()
    {
        $this->_idle = null;
        $this->_signals = null;
    }
}