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
    public function __construct($time, $precision = \prggmr\Engine::IDLE_MILLISECONDS)
    {
        parent::__construct($time, $precision);
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
            switch($this->_precision) {
                case \prggmr\Engine::IDLE_SECONDS:
                    $this->_info = $this->_time + time();
                    break;
                case \prggmr\Engine::IDLE_MILLISECONDS:
                    $this->_info = $this->_time + milliseconds();
                    break;
                case \prggmr\Engine::IDLE_MICROSECONDS:
                    $this->_info = $this->_time + microseconds();
                    break;
            }
            $this->signal_this(true);
        }
        switch($this->_precision) {
            case \prggmr\Engine::IDLE_SECONDS:
                $this->_routine->set_idle_seconds(
                    $this->_info - $current
                );
                break;
            case \prggmr\Engine::IDLE_MILLISECONDS:
                $this->_routine->set_idle_milliseconds(
                    $this->_info - $current
                );
                break;
            case \prggmr\Engine::IDLE_MILLISECONDS:
                $this->_routine->set_idle_microseconds(
                    $this->_info - $current
                );
                break;
        }
        return true;
    }
}