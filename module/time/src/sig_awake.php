<?php
namespace time;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use xpspl\idle\Time;

 /**
 * Awake Signal
 *
 * Sends an awake signal after a specified amount of time has passed.
 */
class SIG_Awake extends \xpspl\signal\Complex {

    /**
     * Time to awake in.
     *
     * @param  integer
     */
    protected $_time = null;

    /**
     * Time instruction.
     *
     * @param  integer
     */
    protected $_instruction = null;

    /**
     * Constructs a awake signal.
     *
     * @param  int  $time  Amount of time before emitting the signal.
     *
     * @throws  InvalidArgumentException
     *
     * @return  void
     */
    public function __construct($time, $instruction = TIME_SECONDS)
    {
        if ((!is_int($time) || !is_float($time)) && $time < 0) {
            throw new \InvalidArgumentException(
                "Time must be greater than 0"
            );
        }
        parent::__construct();
        $this->_time = $time;
        $this->_instruction = $instruction;
        $this->_routine->set_idle(new Time($time, $instruction));
    }
    
    /**
     * Runs the routine.
     *
     * This checks if the appriorate amount of time has passed and emits the 
     * awake signal if so.
     * 
     * @return  boolean
     */
    public function routine($history = null)
    {
        if ($this->_routine->get_idle()->has_time_passed()) {
            $this->signal_this();
            $this->_routine->set_idle(new Time(
                $this->_time, $this->_instruction
            ));
        }
        return true;
    }
}