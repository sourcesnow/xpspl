<?php
namespace prggmr\engine\event;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * Error Event
 */
class Error extends \prggmr\Event {

    protected $_error_data = null;

    /**
     * Construction allow for setting the event TTL.
     *
     * @param  integer  $ttl  TTL in milliseconds for the event.
     *
     * @return  object  prggmr\Event
     */
    public function __construct($data = null, $ttl = null)
    {
        $this->_error_data = $data;
        parent::__construct($ttl);
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