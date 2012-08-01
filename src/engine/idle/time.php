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
class Time extends prggmr\engine\Idle {

    /**
     * Idle time declarations
     */
    const SECONDS = 1;
    const MILLISECONDS = 2;
    const MICROSECONDS = 3;
    const NANOSECONDS = 4;

    /**
     * Amount of time to idle.
     * 
     * @var  integer
     */
    protected $_tti = null;

    /**
     * Type of time.
     *
     * @var  integer
     */
    protected $_type = null;

    /**
     * Time to stop the idle.
     *
     * @var  integer
     */
    protected $_tts = null;

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
    public function __construct($time, $type)
    {
        if ($type <= 0 || $type >= 5) {
            throw new \InvalidArgumentException(
                "Invalid idle time"
            );
        }
        $this->_tti = $time;
        switch ($this->_type) {
            case self::SECONDS:
                $this->_tts = $time + time();
                break;
            case self::MILLISECONDS:
                $this->_tts = $time + milliseconds();
                break;
            case self::MICROSECONDS:
                $this->_tti = $time + microseconds();
                break;
            case self::NANOSECONDS:
                time_nanosleep(0, $this->_tti);
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
        switch ($this->_type) {
            case self::SECONDS:
                sleep($this->_tti);
                break;
            case self::MILLISECONDS:
                usleep($this->_tti * 1000);
                break;
            case self::MICROSECONDS:
                usleep($this->_tti);
                break;
            case self::NANOSECONDS:
                time_nanosleep(0, $this->_tti);
                break;
        }
    }

    /**
     * Determine if the given time idle function is less than the current.
     *
     * @
     */
}