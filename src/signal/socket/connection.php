<?php
namespace prggmr\signal\socket;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Socket stream connection signal.
 */
class Connection extends \prggmr\Signal {

    /**
     * The socket connection.
     *
     * @var  resource
     */
    protected $_socket = null;

    /**
     * Constructs a new socket stream.
     *
     * @param  string  $address  Address to make the connection on.
     * @param  string  $type  The network connection type. tcp|udp
     *
     * @return  void
     */
    public function __construct($socket = null) 
    {
        $this->_socket = $socket;
        parent::__construct('prggmr_server_connection');
    }

    /**
     * Returns the socket connection.
     *
     * @return  resource
     */
    public function get_socket(/* ... */)
    {
        return $this->_socket;
    }
}