<?php
namespace prggmr\signal\socket;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Socket stream server class.
 */
class Server extends \prggmr\signal\Complex {

    use Socket;

    /**
     * Connection signal.
     *
     * @param  object
     */
    protected $_connection = null;

    /**
     * Constructs a new socket stream.
     *
     * @param  string  $address  Address to make the connection on.
     * @param  string  $type  The network connection type. tcp|udp
     *
     * @return  void
     */
    public function __construct($address, $type = 'tcp') 
    {
        // Establish a connection
        $errno = $errstr = null;
        $this->_socket = stream_socket_server(sprintf(
            '%s://%s',
            $type, $address
        ), $errno, $errstr);
        if (0 !== $errno || "" !== $errstr) {
            throw new \RuntimeException(sprintf(
                "Could not connect to socket %s (%s) %s",
                $address, $errno, $errstr
            ));
        }
        // Non-blocking
        stream_set_blocking($this->_socket, 0);

        $this->_connection = new Connection(sprintf('%s_new_connection',
            spl_object_hash($this)
        ));

        // Shutdown the stream
        parent::__construct(null);
    }

    /**
     * Runs the server routine, this will register the idle function to
     * listen on the given socket.
     *
     * @return  boolean
     */
    public function routine($history = null) 
    {
        $this->_routine->set_idle_function(function($engine){
            if (false !== $socket = @stream_socket_accept($this->_socket, 30)) {
                $this->_connection->set_socket($socket);
                $this->_routine->add_signal($this->_connection);
            }
        });
        return true;
    }

    /**
     * Returns the signal triggered for a new connection.
     *
     * @return  object
     */
    public function connect(/* ... */)
    {
        return $this->_connection;
    }
}