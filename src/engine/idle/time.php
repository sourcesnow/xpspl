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
 * The amount of time can be specified in seconds or milliseconds.
 */
class Time extends \prggmr\engine\Idle {

    /**
     * Idle time instruction declarations
     */
    const SECONDS = 1;
    const MILLISECONDS = 2;
    // const MICROSECONDS = 3;

    /**
     * Length of time to idle
     * 
     * @var  integer
     */
    protected $_idle_length = null;

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
    protected $_stop_time = null;

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
        $this->_idle_length = $time;
        $this->_instruction = $instruction;
        switch ($this->_instruction) {
            case self::SECONDS:
                $this->_stop_time = $time + time();
                break;
            case self::MILLISECONDS:
                $this->_stop_time = $time + milliseconds();
                break;
            // case self::MICROSECONDS:
            //     $this->_stop_time = $time + microseconds();
            //     break;
        }
    }

    /**
     * Runs the idle function, this will call either sleep or usleep
     * depending upon the type.
     *
     * @return  void
     */
    public function idle($engine)
    {
        echo "RUNNING ME";
        switch ($this->_instruction) {
            case self::SECONDS:
                sleep($this->get_time_left());
                break;
            case self::MILLISECONDS:
                usleep($this->get_time_left() * 1000);
                break;
            // case self::MICROSECONDS:
            //     usleep($this->_idle_length);
            //     break;
        }
    }

    /**
     * Returns the length of time to idle.
     *
     * @return  integer
     */
    public function get_length(/* ... */)
    {
        return $this->_idle_length;
    }

    /**
     * Returns the length of time to idle until.
     *
     * @return  integer
     */
    public function get_time_until(/* ... */)
    {
        return $this->_stop_time;
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
     * Returns the amount of time left until the idle should stop.
     *
     * @return  integer|float
     */
    public function get_time_left()
    {
        switch ($this->_instruction) {
            case self::SECONDS:
                return $this->_stop_time - time();
                break;
            case self::MILLISECONDS:
                return $this->_stop_time - milliseconds();
                break;
            // case self::MICROSECONDS:
            //     return $this->_stop_time - microseconds();
            //     break;
        } 
    }

    /**
     * Converts length of times from and to seconds, milliseconds and 
     * microseconds.
     *
     * @param  integer|float  $length
     * @param  integer  $to  To instruction
     *
     * @return  integer|float
     */
    public function convert_length($length, $to)
    {
        switch ($this->_instruction) {
            case self::SECONDS:
                switch($to) {
                    case self::MILLISECONDS:
                        return $length / 1000;
                        break;
                    // case self::MICROSECONDS:
                    //     return $length / 1000000;
                }
                break;
            case self::MILLISECONDS:
                switch($to) {
                    case self::SECONDS:
                        return $length * .0001;
                        break;
                    // case self::MICROSECONDS:
                    //     return $length / 1000;
                    //     break;
                }
                break;
            // case self::MICROSECONDS:
            //     switch($to) {
            //         case self::SECONDS:
            //             return $length * 1e-6;
            //             break;
            //         case self::MILLISECONDS:
            //             return $length * .0001;
            //             break;
            //     }
            //     break;
        }
        return $length;
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
                return $this->_stop_time <= time();
                break;
            case self::MILLISECONDS:
                return $this->_stop_time <= milliseconds();
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
        $this_left = $this->convert_length(
            $this->get_time_left(), 
            self::SECONDS
        );
        $that_left = $time->convert_length(
            $time->get_time_left(),
            self::SECONDS
        );
        return $that_left < $this_left;
    }
}
