<?php
namespace xpspl\socket;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \xpspl\processor\idle as idle,
    \xpspl\Handle;

/**
 * Client
 *
 * Connected client socket.
 */
class Client extends Connection {

    /**
     * Socket that is connected.
     *
     * @var  resource
     */
    protected $_socket = null;

    /**
     * Constructs a new client connection.
     *
     * @param  resource  $socket  Socket connection.
     *
     * @return  void
     */
    public function __construct($socket)
    {
        $this->_socket = $socket;
        if (false === $this->_connect()) {
            \xpspl\throw_socket_error();
        }
    }

    /**
     * Establishes the socket connection.
     *
     * @return  boolean
     */
    protected function _connect(/* ... */) 
    {
        if (false === @socket_accept($this->_socket)) {
            return false;
        }
        socket_set_nonblock($this->_socket);
        return true;
    }
}