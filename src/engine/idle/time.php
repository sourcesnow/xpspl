<?php
namespace prggmr\engine\idle;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Idles the engine for a specific amount of time.
 *
 * The amount of time can be specified in seconds, milliseconds, microseconds
 * or nanoseconds.
 */
class Time extends \prggmr\engine\Idle {

    /**
     * Idle time instruction declarations
     */
    const SECONDS = 1;
    const MILLISECONDS = 2;
    const MICROSECONDS = 3;

    /**
     * Amount of time to idle.
     * 
     * @var  integer
     */
    protected $_tti = null;

    /**
     * Instruction of sleep type.
     *
     * @var  integer
     */
    protected $_instruction = null;

    /**
     * Time to stop the idle.
     *
     * @var  integer
     */
    protected $_tts = null;

    /**
     * Priority of this idle function.
     *
     * @var  integer
     */
    protected $_priority = 2;

    /**
     * Allow override of this function.
     *
     * When set to true the "override" method will be called otherwise the 
     * engine will signal a Idle_Function_Overflow.
     *
     * @var  boolean
     */
    protected $_allow_override = true;
    

    /**
     * Constructs the time idle.
     */
    public function __construct($time, $instruction)
    {
        if ($instruction <= 0 || $instruction >= 4) {
            throw new \InvalidArgumentException(
                "Invalid idle time instruction"
            );
        }
        $this->_tti = $time;
        $this->_instruction = $instruction;
        switch ($this->_instruction) {
            case self::SECONDS:
                $this->_tts = $time + time();
                break;
            case self::MILLISECONDS:
                $this->_tts = $time + milliseconds();
                break;
            case self::MICROSECONDS:
                $this->_tts = $time + microseconds();
                break;
        }
    }

    /**
     * Runs the idle function, this will call either sleep, usleep or 
     * time_nanosleep dependent upon the type.
     *
     * @return  void
     */
    public function idle($engine)
    {
        switch ($this->_instruction) {
            case self::SECONDS:
                sleep($this->_tti);
                break;
            case self::MILLISECONDS:
                usleep($this->_tti * 1000);
                break;
            case self::MICROSECONDS:
                usleep($this->_tti);
                break;
        }
    }

    /**
     * Returns the length of time to idle.
     *
     * @return  integer
     */
    public function get_length(/* ... */)
    {
        return $this->_tti;
    }

    /**
     * Returns the length of time to idle until.
     *
     * @return  integer
     */
    public function get_time_until(/* ... */)
    {
        return $this->_tts;
    }

    /**
     * Returns the type of time.
     *
     * @return  integer
     */
    public function get_instruction(/* ... */)
    {
        return $this->_instruction;
    }

    /**
     * Determines if the time to idle until has passed.
     *
     * @return  boolean
     */
    public function has_time_passed(/* ... */)
    {
        switch ($this->_instruction) {
            case self::SECONDS:
                return $this->_tts <= time();
                break;
            case self::MILLISECONDS:
                return $this->_tts <= milliseconds();
                break;
            case self::MICROSECONDS:
                return $this->_tts <= microseconds();
                break;
        }
    }

    /**
     * Determine if the given time idle function is less than the current.
     *
     * @param  object  $time  Time idle object
     *
     * @return  boolean
     */
    public function override($time)
    {
        if ($this->has_time_passed()) {
            return true;
        }
        $instruction = $time->get_instruction();
        switch ($instruction) {
            case self::SECONDS:
                switch ($this->_instruction) {
                    case self::SECONDS:
                        if ($this->_tts <= $time->get_time_until()) {
                            return false;
                        }
                        return true;
                        break;
                    case self::MILLISECONDS:
                        $difference = ($this->_tts - milliseconds()) / 1000;
                        if ($difference >= ($time->get_time_until() - time())) {
                            return true;
                        }
                        return false;
                        break;
                    case self::MICROSECONDS:
                        $difference = ($this->_tts - microseconds()) / 1000000;
                        if ($difference >= ($time->get_time_until() - time())) {
                            return true;
                        }
                        return false;
                        break;
                }
                break;
            case self::MILLISECONDS:
                switch ($this->_instruction) {
                    case self::SECONDS:
                        $difference = ($this->_tts - time()) * 1000;
                        if ($difference >= ($time->get_time_until() - milliseconds())) {
                            return true;
                        }
                        return false;
                        break;
                    case self::MILLISECONDS:
                        if ($this->_tts >= ($time->get_time_until() - milliseconds())) {
                            return true;
                        }
                        return false;
                        break;
                    case self::MICROSECONDS:
                        $difference = ($this->_tts - microseconds()) / 1000;
                        if ($difference >= ($time->get_time_until() - milliseconds())) {
                            return true;
                        }
                        return false;
                }
                break;
            case self::MICROSECONDS:
                switch ($this->_instruction) {
                    case self::SECONDS:
                        $difference = ($this->_tts - time()) * 1000000;
                        if ($difference >= ($time->get_time_until() - microseconds())) {
                            return true;
                        }
                        return false;
                        break;
                    case self::MILLISECONDS:
                        $difference = ($this->_tts - milliseconds()) * 1000;
                        if ($difference <= ($time->get_time_until() - microseconds())) {
                            echo $difference . ' is smaller than ' . ($time->get_time_until() - microseconds());
                            return true;
                        }
                        return false;
                        break;
                    case self::MICROSECONDS:
                        if ($this->_tts >= $time->get_time_until()) {
                            return true;
                        }
                        return false;
                        break;
                }
                break;
        }
    }
}
