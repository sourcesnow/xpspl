<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Declared for use.
 */
define('STATE_DECLARED' , 0x00001);
/**
 * Currently running in execution.
 */
define('STATE_RUNNING'  , 0x00002);
/**
 * Execution finised.
 */
define('STATE_EXITED'   , 0x00003);
/**
 * Error encountered.
 */
define('STATE_ERROR'    , 0x00004);
/**
 * Successfully ran through a lifecycle and reused.
 */
define('STATE_RECYCLED' , 0x00005);
/**
 * Corrupted during runtime execution and recovery was succesful.
 */
define('STATE_RECOVERED', 0x00006);
/**
 * The object has declared to stop any further execution.
 */
define('STATE_HALTED'   , 0x00007);

/**
 * State
 *
 * @since 0.3.0
 *
 * State is as it implies, state of a given object.
 */ 
trait State
{
    /**
     * Current state of the object.
     *
     * @var  int
     */
    protected $_state = null;

    /**
     * Constructs a new state object.
     * 
     * @return  void
     */
    public function __construct() 
    {
        $this->_state = STATE_DECLARED;
    }

    /**
     * Returns the current event state.
     *
     * @return  integer  Current state of this event.
     */
    final public function get_state(/* ... */)
    {
        return $this->_state;
    }

    /**
     * Set the object state.
     *
     * @param  int  $state  State of the object.
     *
     * @throws  InvalidArgumentException
     *
     * @return  void
     */
    final public function set_state($state) 
    {
        $this->_state = $state;
    }
}
