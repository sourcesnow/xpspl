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
     * Time at which the idle should stop.
     */

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
        $this->_tti = 
    }
}