<?php
namespace prggmr\signal\time;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
 
 /**
 * Time signal
 *
 * Trigger a signal based on timed intervals in milliseconds.
 *
 * As of v2.0 intervals can be set on a second, millisecond or microsecond basis
 */
class Interval extends \prggmr\signal\time\Timeout {

    /**
     * Milliseconds before signaling.
     * 
     * @var  integer
     */
    protected $_time = null;

    /**
     * Constructs a time signal.
     *
     * @param  int  $time  Milliseconds before signaling.
     *
     * @throws  InvalidArgumentException
     *
     * @return  void
     */
    public function __construct($time, $precision = \prggmr\engine\idle\Time::MILLISECONDS)
    {
        parent::__construct($time, $precision);
        $this->_time = $time;
    }
    

    /**
     * Determines the time in the future that this signal should trigger and
     * and sets the engines idle time until then. 
     * 
     * @return  void
     */
    public function routine($history = null)
    {
        if ($this->_idle->has_time_passed()) {
            $this->_idle = \prggmr\engine\idle\Time($this->_time, $this->_instruction);
            $this->signal_this();
        }
        $this->_routine->set_idle($this->_idle);
        return true;
    }
}