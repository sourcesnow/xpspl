<?php
namespace XPSPL\processor\signal;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * The error event
 */
class Error extends Base  {

    /**
     * Error message
     * 
     * @var  string
     */
    protected $_error = null;

    /**
     * Exception
     *
     * @var  object
     */
    protected $_exception = null;

    /**
     * Constructs a new signal.
     *
     * @param  string  $error  Error message.
     * @param  object|null  $exception  Exception object if exists
     *
     * @return  void
     */
    public function __construct($error = null, $exception = null) 
    {
        $this->_error = $error;
        $this->_exception = $exception;
    }

    /**
     * Returns the error message.
     *
     * @return  string
     */
    public function get_error(/* ... */)
    {
        return $this->_error;
    }

    /**
     * Returns the exception, if set.
     *
     * @return  object|null
     */
    public function get_exception(/* ... */)
    {
        return $this->_exception;
    }

}