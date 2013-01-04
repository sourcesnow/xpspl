<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \Closure,
    \Exception,
    \RuntimeException;

/**
 * Process
 * 
 * A process is a callable which will execute when a signal is emitted.
 */
class Process {

    /**
     * The function that will execute when this process is called.
     */
    protected $_function = null;

    /**
     * Process is exhaustion.
     *
     * @var  integer|null
     */
    protected $_exhaustion = 1;

    /**
     * Process priority.
     *
     * @var  integer
     */
    protected $_priority = null;

    /**
     * Constructs a new process object.
     *
     * @param  mixed  $function  A callable php variable.
     * @param  integer  $exhaust  Count to set process exhaustion.
     * @param  null|integer  $priority  Priority of the process.
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
     * Returns count until process becomes exhausted
     *
     * @return  integer
     */
    public function exhaustion(/* ... */)
    {
        return $this->_exhaustion;
    }

    /**
     * Determines if the process has exhausted.
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
     * Returns the priority of the process.
     *
     * @return  integer
     */
    public function get_priority(/* ... */)
    {
        return $this->_priority;
    }

    /**
     * Returns the function for the process.
     *
     * @return  closure|array
     */
    public function get_function(/* ... */)
    {
        return $this->_function;
    }

    /**
     * Sets the process exhaust rate.
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
     * Sets the process priority.
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