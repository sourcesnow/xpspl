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
     * @var  object
     */
    protected $_connect = null;

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
        // prggmr forces non-blocking
        stream_set_blocking($this->_socket, 0);

        $this->_connect = new Connect(sprintf('%s_connect',
            spl_object_hash($this)
        ));

        $this->_disconnect = new Disconnect(sprintf('%s_disconnect',
            spl_object_hash($this)
        ));

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
        /**
         * This allows for the signals to signal something within the server
         * socket. This is done by passing the $server signal to the event
         * I'm currently pondering a better solution for now this works.
         */
        if (count($this->_routine->get_signals()) !== 0) {
            return true;
        }
        $this->_routine->set_idle_function(function($engine){
            if (false !== $socket = @stream_socket_accept($this->_socket, 30)) {
                $this->_routine->add_signal(
                    $this->_connect,
                    new event\Connect($socket, $this)
                );
            }
        });
        return true;
    }

    /**
     * Returns the signal triggered for a new connection.
     *
     * @return  object
     */
    public function on_connect(/* ... */)
    {
        return $this->_connect;
    }

    /**
     * Returns the disconnect signals.
     *
     * @return  object
     */
    public function on_disconnect(/* ... */)
    {
        return $this->_disconnect;
    }

     /**
     * Sends the disconnection signal.
     *
     * @param  resource  $socket  Socket that disconnected
     *
     * @return  void
     */
    public function send_disconnect($socket)
    {
        $this->_routine->add_signal(
            $this->_disconnect,
            new event\Disconnect($socket, $this)
        );
    }
}