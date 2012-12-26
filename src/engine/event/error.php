<?php
namespace xpspl\engine\event;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * Error
 * 
 * Event used for errors which have occured during engine operation.
 */
class Error extends \xpspl\Event {

    protected $_error_data = null;

    /**
     * Generates a new error event.
     *
     * @param  array  Multiple param values (UNEXPECTED)
     *
     * @return  void
     */
    public function __construct()
    {
        $this->_error_data = func_get_args();
        parent::__construct();
    }

    /**
     * Returns the data associated with the error.
     *
     * @return  mixed
     */
    public function get_error_data()
    {
        return $this->_error_data;
    }
}