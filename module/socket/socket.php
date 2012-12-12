<?php
namespace prggmr\module\socket;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \prggmr\engine\idle as idle;

/**
 * Socket
 *
 * Event driven I/O for files or networks.
 */
class Socket extends Base {

    /**
     * Signal dispatched when a data becomes available.
     *
     * @var  object
     */
    protected $_on_read = null;

    /**
     * Signal dispatched when a data is written.
     *
     * @var  object
     */
    protected $_on_write = null;

    /**
     * Client sockets currently connected for read/write.
     *
     * @var  array
     */
    protected $_clients = [];

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

        // used for when clients read/write
        $this->_on_read = new signal\Read(sprintf('%s_read',
            spl_object_hash($this)
        ));
        $this->_on_write = new signal\Write(sprintf('%s_write',
            spl_object_hash($this)
        ));

        $this->on_disconnect(new \prggmr\Handle(function(){
            fclose($this->get_socket());
        }, null, PHP_INT_MAX));

        parent::__construct();

        // add the routine for this signal
        $this->_routine->add_signal(
            $this, new signal\Connect($this->_socket, null)
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
        $this->_socket = socket_create(
            $this->_options['domain'], 
            $this->_options['type'], 
            $this->_options['protocol']
        );
        $bind = socket_bind(
            $this->_socket, $this->_address, $this->_options['port']
        );
        if (false === $bind) {
            $code = socket_last_error();
            $str = socket_strerror($code);
            throw new \RuntimeException(sprintf(
                'Could not connect to socket (%s) - %s',
                $code, $str
            ));
        }
        // listen
        socket_listen($this->_socket);
        // force non-blocking
        socket_set_nonblock($this->_socket);
    }

    /**
     * Disconnects from the socket.
     *
     * @return  void
     */
    public function disconnect(/* ... */)
    {
        fclose($this->_socket);
    }

    /**
     * Runs the server routine, this will register the idle function to
     * listen on the given socket.
     *
     * @return  boolean
     */
    public function routine($history = null) 
    {
        $this->_routine->set_idle(new idle\Func(function($engine){
            $idle = $engine->get_routine()->get_idles_available();
            // 30 second default wait
            $time = 30;
            if (count($this->_routine->get_signals()) !== 0) {
                $time = 0;
            } elseif (count($idle) == 2) {
                foreach ($idle as $_idle) {
                    if ($_idle instanceof idle\Time) {
                        $time = round($_idle->convert_length(
                            $_idle->get_time_left(), 
                            idle\Time::SECONDS
                        ), 3);
                        break;
                    }
                }
            }
            $read = array_merge([$this->_socket], $this->_clients);
            // $read = [$this->_socket];
            $write = $this->_clients;
            $ex = null;
            if (false !== $count = socket_select($read, $write, $ex, $time)) {
                if ($count == 0) return true;
                if (count($read) !== 0) {
                    foreach ($read as $_read) {
                        if (!in_array($_read, $this->_clients, true)) {
                            $socket = socket_accept($_read);
                            socket_set_nonblock($socket);
                            $this->_routine->add_signal(
                                $this->_connect,
                                new event\Connect($socket, $this)
                            );
                            $this->_clients[] = $socket;
                        } else {
                            $this->_routine->add_signal(
                                $this->_read,
                                new event\Read($_read, $this)
                            );
                        }
                    }
                }
                if (count($write) !== 0) {
                    foreach ($write as $_write) {
                        $this->_routine->add_signal(
                            $this->_write,
                            new event\Write($_write, $this)
                        );
                    }
                }
            }
        }));
        return true;
    }

    /**
     * Registers a new handle for client read.
     *
     * @param  callable  $function  Function to call on connect.
     *
     * @return  object
     */
    public function on_read($function)
    {
        if (!$function instanceof \prggmr\Handle) {
            $function = new \prggmr\Handle($function, null);
        }
        return \prggmr\handle(
            $this->_read, $function
        );
    }

    /**
     * Registers a new handle for client write.
     *
     * @param  callable  $function  Function to call on connect.
     *
     * @return  object
     */
    public function on_write($function)
    {
        if (!$function instanceof \prggmr\Handle) {
            $function = new \prggmr\Handle($function, null);
        }
        return \prggmr\handle(
            $this->_write, $function
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
            new socket\event\Disconnect($socket, $this)
        );
    }

    /**
     * Returns a new event for connection.
     *
     * @return  object
     */
    protected function _get_connection_event($socket)
    {
        return new socket\event\Connect($socket, $this);
    }

    /**
     * Returns the currently connected clients.
     *
     * @return  array
     */
    public function get_clients(/* ... */)
    {
        return $this->_clients;
    }
}