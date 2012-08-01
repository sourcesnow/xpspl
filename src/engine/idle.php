<?php
namespace prggmr\engine;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * The idle class is used for idling the engine, the base provides no 
 * functionality in itself and must be extended.
 *
 * What it does provide is a base for writing an idle object, with this it
 * gives the default functions of setting the maximum of itself allowed per 
 * loop, the priority of the idling function and allow override of the same
 * idle.
 */
abstract class Idle {

    /**
     * Amount of this idle that can be run each loop.
     *
     * @var  integer
     */
    protected $_limit = 1;

    /**
     * Priority of this idle function.
     *
     * @var  integer
     */
    protected $_priority = 100;

    /**
     * Allow override of this function.
     *
     * When set to true the "override" method will be called otherwise the 
     * engine will signal a Idle_Function_Overflow.
     *
     * @var  boolean
     */
    protected $_allow_override = false;

    /**
     * Idle's the engine.
     *
     * This function is purely responsible for providing the engine the ability
     * to idle, typically this will be done through either a call to sleep or a
     * wait with a specific timeout.
     *
     * This method is provided an instance of the engine which is wishing to 
     * idle and should respect the engines current specifications for the amount
     * of time that it needs to idle, if set.
     *
     * You have been warned that,
     *
     * Creating a function that does not properly idle, does not respect the
     * engine specs or is poorly developed will result in terrible performance 
     * unexpected results and damaging to your system ... use caution.
     * 
     * @param  object  $engine  The engine that wishes to idle.
     *
     * @return  void
     */
    public function idle($engine)
    {
        throw new \BadMethodCallException(sprintf(
            "Idle function for %s has not been implemented"
        ), get_class($this));
    }

    /**
     * Returns the priority of this idle function.
     *
     * @return  integer
     */
    public function get_priority(/* ... */)
    {
        return $this->_priority;
    }

    /**
     * Returns the maximum amount of idle functions allowed of this.
     *
     * @return  integer
     */
    public function get_limit(/* ... */)
    {
        return $this->_limit;
    }

    /**
     * Return if this function allows itself to be overwritten in the limit
     * is met or exceeded.
     *
     * @return  boolean
     */
    public function allow_override(/* ... */)
    {
        return $this->_allow_override;
    }

    /**
     * Returns if the given function can override this in the engine.
     *
     * @param  object  $idle  Idle function object
     *
     * @return  boolean
     */
    public function override($idle)
    {
        return false;
    }
}