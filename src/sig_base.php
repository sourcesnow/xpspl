<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

define('SIGNAL_SELF_PARENT', -0xE4E);

use \XPSPL\State;

/**
 * Base Signal
 * 
 * Base class for all XPSPL signals.
 */
abstract class SIG_Base {

    use State;

    /**
     * Event the signal represents.
     *
     * @var  string|integer
     */
    protected $_info = null;

    /**
     * Result of the event.
     * 
     * @var  mixed
     */
    protected $_result = null;

    /**
     * Parent event.
     * 
     * @var  object
     */
    protected $_parent = null;

    /**
     * Returns the signal information.
     *
     * @return  boolean
     */
    public function get_info(/* ... */) 
    {
        return $this->_info;
    }

    /**
     * Sets the result of the signal.
     * 
     * @param  mixed  $result
     */
    public function set_result($result)
    {
        $this->_result = $result;
    }

    /**
     * Returns the result of the signal.
     * 
     * @return  mixed
     */
    public function get_result(/* ... */)
    {
        return $this->_result;
    }

    /**
     * Halts the signal execution.
     * 
     * @return  void
     */
    public function halt(/* ... */)
    {
        $this->_state = STATE_HALTED;
    }

    /**
     * Determines if the signal is a child of another signal.
     * 
     * @return  boolean
     */
    public function is_child(/* ... */)
    {
        return null !== $this->_parent;
    }

    /**
     * Sets the parent signal.
     * 
     * @param  object  $signal  \XPSPL\Signal
     * 
     * @return  void
     */
    public function set_parent(Signal $signal)
    {
        // Detect if parent is itself to avoid circular referencing
        if ($this === $signal) $signal = SIGNAL_SELF_PARENT;
        $this->_parent = $signal;
    }

    /**
     * Retrieves this signal's parent.
     * 
     * @return  null|object 
     */
    public function get_parent(/* ... */)
    {
        return ($this->_parent === SIGNAL_SELF_PARENT) ? $this : $this->_parent;
    }

    /**
     * Get a variable in the event.
     *
     * @param  mixed  $key  Variable name.
     *
     * @return  mixed|null
     */
    public function __get($key)
    {
        throw new \LogicException(sprintf(
            "Call to undefined signal property %s",
            $key
        ));
    }

    /**
     * Checks for a variable in the signal.
     *
     * @param  mixed  $key  Variable name.
     *
     * @return  boolean
     */
    public function __isset($key)
    {
        return isset($this->$key);
    }

    /**
     * Set a variable in the signal.
     *
     * @param  string  $key  Name of variable
     *
     * @param  mixed  $value  Value to variable
     *
     * @return  boolean  True
     */
    public function __set($key, $value)
    {
        $this->$key = $value;
        return true;
    }

    /**
     * Deletes a variable in the signal.
     *
     * @param  mixed  $key  Variable name.
     *
     * @return  boolean
     */
    public function __unset($key)
    {
        if (!isset($this->$key)) return false;
        if (stripos($key, '_') === 0) {
            throw new \LogicException(sprintf(
                "%s is a read-only signal property", 
                $key
            ));
        }
        unset($this->$key);
    }
}