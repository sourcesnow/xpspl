<?php
namespace prggmr\module\time;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
 
 /**
 * Timeout signal
 *
 * Trigger a signal based on a timeout delay.
 *
 * As of v2.0 timeouts can be set on a second, millisecond or microsecond basis
 */
class Timeout extends \prggmr\signal\Complex {

    /**
     * The time instruction.
     *
     * @var  integer
     */
    protected $_instruction = null;

    /**
     * The time idle object.
     */
    protected $_idle = null;

    /**
     * Constructs a timeout signal.
     *
     * @param  int  $time  Microseconds before signaling.
     *
     * @throws  InvalidArgumentException
     *
     * @return  void
     */
    public function __construct($delay, $instruction = \prggmr\engine\idle\Time::MILLISECONDS)
    {
        if ((!is_int($delay) || !is_float($delay)) && $delay < 0) {
            throw new \InvalidArgumentException(
                "Delay given must be greater than 0"
            );
        }
        $this->_instruction = $instruction;
        $this->_idle = new \prggmr\engine\idle\Time($delay, $instruction);
        parent::__construct();
    }
    
    /**
     * Determines the time in the future that this signal should trigger and
     * and sets the engines idle time until then. 
     * 
     * @return  void
     */
    public function routine($history = null)
    {
        if (null === $this->_idle) return false;
        if ($this->_idle->has_time_passed()) {
            $this->signal_this();
            $this->_idle = null;
        } else {
            $this->_routine->set_idle($this->_idle);
        }
        return true;
    }
}