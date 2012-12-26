<?php
namespace xpspl\socket;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \xpspl\engine\idle as idle;

/**
 * File
 *
 * Event driven I/O for files.
 */
class File extends Base {

    /**
     * Constructs a new file descriptor socket.
     *
     * @param  string  $address  File resource.
     *
     * @return  void
     */
    public function __construct($resource) 
    {
        parent::__construct();

        $this->_address = $resource;

        $this->_connect();

        // add the routine for this signal
        $this->signal_this(
            new event\Connect($this->socket)
        );
    }

    /**
     * Establishes the socket connection.
     *
     * @return  void
     */
    protected function _connect(/* ... */)
    {
        // Establish a connection
        $this->socket = new Connection($this->_address);
        $bind = @socket_bind(
            $this->socket->get_resource(), 
            $this->_address
        );
        if (false === $bind) {
            \xpspl\throw_socket_error();
        }
        // listen
        socket_listen($this->socket->get_resource());
        socket_set_nonblock($this->socket->get_resource());
    }
}
