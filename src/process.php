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
 * A process is the callable which will execute when a signal is emitted.
 */
class Process {

    /**
     * The callable that will execute.
     */
    protected $_callable = null;

    /**
     * Process exhaustion.
     *
     * @var  integer|null
     */
    protected $_exhaustion = null;

    /**
     * Process priority.
     *
     * @var  integer
     */
    protected $_priority = null;

    /**
     * Constructs a new process object.
     *
     * @param  mixed  $callable  A callable php variable.
     * @param  integer  $exhaust  Count to set process exhaustion.
     * @param  null|integer  $priority  Priority of the process.
     * 
     * @return  void
     */
    public function __construct($callable, $exhaust = PROCESS_DEFAULT_EXHAUST, $priority = PROCESS_DEFAULT_PRIORITY)
    {
        // set exhaust rate
        $this->set_exhaust($exhaust);
        if (null !== $priority && !is_int($priority)) {
            $priority = null;
        }
        $this->_priority = $priority;
        $this->_callable = $callable;
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
        return $this->_callable;
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
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug("Setting priority $priority");
        }
        $this->_priority = $priority;
    }
}