<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Socket
 *
 * Event driven I/O.
 */
class Socket extends Socket_Base {

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
            new EV_Connect($this->connection)
        );

        $this->_register_idle_process();
    }

    /**
     * Establishes the socket connection.
     *
     * @return  void
     */
    protected function _connect(/* ... */)
    {
        // Establish a connection
        $this->connection = new Connection(socket_create(
            $this->_options['domain'], 
            $this->_options['type'], 
            $this->_options['protocol']
        ));
        // timeout
        socket_set_option(
            $this->connection->get_resource(), 
            SOL_SOCKET, 
            SO_RCVTIMEO,
            [
                'sec' => XPSPL_NETWORK_TIMEOUT_SECONDS, 
                'usec' => XPSPL_NETWORK_TIMEOUT_MICROSECONDS
            ]
        );
        $bind = socket_bind(
            $this->connection->get_resource(), 
            $this->_address, 
            $this->_options['port']
        );
        if (false === $bind) {
            throw_socket_error();
        }
        // listen
        socket_listen($this->connection->get_resource());
        socket_set_nonblock($this->connection->get_resource());
    }
}
