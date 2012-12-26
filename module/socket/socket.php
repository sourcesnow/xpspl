<?php
namespace xpspl\socket;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Socket
 *
 * Event driven I/O for networks.
 */
class Socket extends Base {

    /**
     * Constructs a new socket.
     *
     * @param  string  $address  Address to make the connection on.
     * @param  string  $options  Connection options
     *
     * @return  void
     */
    public function __construct($address, $options = []) 
    {
        parent::__construct();

        $defaults = [
            'port' => null,
            'domain' => AF_INET,
            'type' => SOCK_STREAM,
            'protocol' => SOL_TCP
        ];
        $options += $defaults;

        $this->_address = $address;
        $this->_options = $options;

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
        $this->socket = new Connection(socket_create(
            $this->_options['domain'], 
            $this->_options['type'], 
            $this->_options['protocol']
        ));
        $bind = @socket_bind(
            $this->socket->get_resource(), 
            $this->_address, 
            $this->_options['port']
        );
        if (false === $bind) {
            \xpspl\throw_socket_error();
        }
        // listen
        socket_listen($this->socket->get_resource());
        \xpspl\socket_set_nonblock($this->socket->get_resource());
    }
}
