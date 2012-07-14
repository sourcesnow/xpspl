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
 * Trigger a signal based on timed intervals in milliseconds
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
    public function __construct($time)
    {
        parent::__construct($time);
        $this->_time = $time;
    }
    
    /**
     * Determine when the time signal should trigger, otherwise returning
     * the engine to idle until it will.
     * 
     * @return  integer
     */
    public function routine($history = null)
    {
        $current = milliseconds();
        if ($current >= $this->_info) {
            $this->_info = $this->_time + milliseconds();
            $this->signal_this(true);
        }
        $this->_routine->set_idle_time($this->_info - $current);
        return true;
    }
}