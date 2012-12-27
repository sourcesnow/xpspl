<?php
namespace xpspl;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \Closure,
    \Exception,
    \RuntimeException;

/**
 * A handle is the function which will execute upon a signal call.
 *
 * Though attached to a signal the object itself contains no
 * information on what a signal even is, it is possible to couple
 * it within the object, but the handle will unknownly receive an
 * event which contains the same.
 *
 * As of v0.3.0 handles are now designed with an exhausting of 1
 * by default, this is done under the theory that any handle which
 * is registered is done so to run at least once, otherwise it wouldn't
 * exist.
 */
class Handle {

    /**
     * The function that will execute when this handle is called.
     */
    protected $_function = null;

    /**
     * Handle is exhaustion.
     *
     * @var  integer|null
     */
    protected $_exhaustion = 1;

    /**
     * Handle priority.
     *
     * @var  integer
     */
    protected $_priority = null;

    /**
     * Constructs a new handle object.
     *
     * @param  mixed  $function  A callable php variable.
     * @param  integer  $exhaust  Count to set handle exhaustion.
     * @param  null|integer  $priority  Priority of the handle.
     * 
     * @return  void
     */
    public function __construct($function, $exhaust = EXHAUST_DEFAULT, $priority = null)
    {
        if (null === $function || is_int($function) || is_bool($function)) {
            throw new \InvalidArgumentException;
        }
        // set exhaust rate
        $this->set_exhaust($exhaust);
        // set priority
        $this->set_priority($priority);
        // unbind the closure if is
        if ($function instanceof \Closure) {
            $this->_function = clone $function;
        } else {
            $this->_function = $function;
        }
    }

    /**
     * Decrements the exhaustion counter.
     *
     * @return  void
     */
    public function decrement_exhaust(/* ... */)
    {
        if (null !== $this->_exhaustion) {
            $this->_exhaustion--;
        }
    }

    /**
     * Returns count until handle becomes exhausted
     *
     * @return  integer
     */
    public function exhaustion(/* ... */)
    {
        return $this->_exhaustion;
    }

    /**
     * Determines if the handle has exhausted.
     *
     * @return  boolean
     */
    public function is_exhausted()
    {
        if (null === $this->_exhaustion) {
            return false;
        }

        if (0 >= $this->_exhaustion) {
            return true;
        }

        return false;
    }

    /**
     * Returns the priority of the handle.
     *
     * @return  integer
     */
    public function get_priority(/* ... */)
    {
        return $this->_priority;
    }

    /**
     * Returns the function for the handle.
     *
     * @return  closure|array
     */
    public function get_function(/* ... */)
    {
        return $this->_function;
    }

    /**
     * Sets the handle exhaust rate.
     *
     * @param  integer  $rate  Exhaust rate
     * 
     * @return  void
     */
    public function set_exhaust($rate)
    {
        # Invalid or negative exhausting sets the rate to 1.
        if (null !== $rate && (!is_int($rate) || $rate <= -1)) {
            return;
        }
        $this->_exhaustion = $rate;
    }

    /**
     * Sets the handle priority.
     *
     * @param  integer  $priority  Integer Priority
     * 
     * @return  void
     */
    public function set_priority($priority)
    {
        # Invalid or negative exhausting sets the rate to 1.
        if (null !== $priority && !is_int($priority)) {
            return;
        }
        $this->_priority = $priority;
    }
}