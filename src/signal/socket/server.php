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
     * Instance of an engine to use for signaling.
     *
     * @var  null|object
     */
    protected $_engine = null;

    /**
     * Network address
     *
     * @var  string
     */
    protected $_address = null;

    /**
     * Constructs a new network socket stream.
     *
     * @param  string  $address  Address to make the connection on.
     * @param  string  $type  The network connection type. tcp|udp
     *
     * @return  void
     */
    public function __construct($address, $type = 'tcp', $engine = null) 
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

        $this->_address = $address;

        // prggmr forces non-blocking
        stream_set_blocking($this->_socket, 0);

        $this->_connect = new Connect(sprintf('%s_connect',
            spl_object_hash($this)
        ));
        $this->_disconnect = new Disconnect(sprintf('%s_disconnect',
            spl_object_hash($this)
        ));

        if (null !== $engine && $engine instanceof \prggmr\Engine) {
            $this->_engine = $engine;
        }

        // Disconnect the connection immediatly after connecting
        // these are forced into the server
        $this->on_connect(function(){
            $this->disconnect();
        }, PHP_MAX_INT, null);

        $this->on_disconnect(function(){
            stream_socket_shutdown($this->get_socket(), STREAM_SHUT_RDWR);
        }, PHP_MAX_INT, null);

        parent::__construct(null);

        $this->_routine->add_signal(
            $this, new event\Server($this->_socket)
        );
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
            $idle = $engine->get_routine()[1];
            if ($)
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
     * Registers a new handle for new connections.
     *
     * @param  callable  $function  Function to call on connect.
     * @param  integer|null  $priority  Priority of this function.
     * @param  integer|null  $exhaust  Exhaustion of this function.
     *
     * @return  object
     */
    public function on_connect($function, $priority = null, $exhaust = null)
    {
        return $this->get_engine()->handle(
            $function, $this->_connect, $priority, $exhaust
        );
    }

    /**
     * Registers a new handle for disconnections.
     *
     * @param  callable  $function  Function to call on connect.
     * @param  integer|null  $priority  Priority of this function.
     * @param  integer|null  $exhaust  Exhaustion of this function.
     *
     * @return  object
     */
    public function on_disconnect($function, $priority = null, $exhaust = null)
    {
        return $this->get_engine()->handle(
            $function, $this->_disconnect, $priority, $exhaust
        );
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

    /**
     * Returns the prggmr engine used for this server.
     *
     * @return  object
     */
    public function get_engine(/* ... */)
    {
        if (null !== $this->_engine) {
            return $this->_engine;
        }
        return \prggmr::instance();
    }

    /**
     * Returns the address for the network socket.
     *
     * @return  string
     */
    public function get_address(/* ... */)
    {
        return $this->_address;
    }
}