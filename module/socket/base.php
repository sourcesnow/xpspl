<?php
namespace prggmr\socket;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \prggmr\engine\idle\Func;

/**
 * Base
 *
 * Base signal for a socket.
 */
abstract class Base extends \prggmr\signal\Complex {

    /**
     * Socket connection object
     *
     * @var  object
     */
    public $connection = null;

    /**
     * Socket Address
     *
     * @var  string
     */
    protected $_address = null;

    /**
     * Options used for the socket.
     */
    protected $_options = [];

    /**
     * Client sockets currently connected for read/write.
     *
     * @var  array
     */
    protected $_clients = [];

    /**
     * Constructs a new socket
     */
    public function __construct(/* ... */)
    {
        parent::__construct();
    }

    /**
     * Reconnects the socket.
     *
     * It will attempt to close before reconnecting.
     *
     * @return  void
     */
    public function reconnect(/* ... */)
    {
        $this->connection->disconnect();
        $this->_connect();
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

    /**
     * Registers a new handle for disconnections.
     *
     * @param  callable  $function  Function to call on connect.
     *
     * @return  object
     */
    public function on_disconnect($function)
    {
        if (!$function instanceof \prggmr\Handle) {
            $function = new \prggmr\Handle($function, null);
        }
        return \prggmr\handle(
            new signal\Disconnect($this), $function
        );
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
            new signal\Read($this), $function
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
            new signal\Write($this), $function
        );
    }

    /**
     * Registers a new handle for new connections.
     *
     * @param  callable  $function  Function to call on connect.
     *
     * @return  object
     */
    public function on_connect($function)
    {
        if (!$function instanceof \prggmr\Handle) {
            $function = new \prggmr\Handle($function, null);
        }
        return \prggmr\handle(
            new signal\Connect($this), $function
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
        // Establish the system idle process
        $this->_routine->set_idle(new Func(function($engine){
            $idle = $engine->get_routine()->get_idles_available();
            // 30 second default wait
            $time = 30;
            // Determine if another function has requested to execute in x
            // amount of time
            if (count($this->_routine->get_signals()) !== 0) {
                $time = 0;
            } elseif (count($idle) >= 2) {
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
            // establish sockets
            $re = $wr = $ex = [
                $this->connection->get_resource()
            ];
            foreach ($this->_clients as $_k => $_c) {
                $_r = $_c->get_resource();
                // test if socket is still connected
                // send disconnect if disconnect detected
                if (!is_resource($_r)) {
                    \prggmr\signal(
                        new signal\Disconnect($this),
                        new event\Disconnect($_c)
                    );
                    unset($this->_clients[$_k]);
                    continue;
                }
                $re[] = $_r;
                $wr[] = $_r;
                $ex[] = $_r;
            }
            if (false !== $count = socket_select($re, $write, $ex, $time)) {
                if ($count == 0) return true;
                if (count($re) !== 0) {
                    foreach ($re as $_r) {
                        if (!isset($this->_clients[$_r])) {
                            try {
                                $client = new Client($_r);
                            } catch (\RuntimeException $e) {
                                // right now this silenty fails
                                continue;
                            }
                            $this->_routine->add_signal(
                                new signal\Connect($this),
                                new event\Connect($client)
                            );
                            $this->_clients[$client->get_resource()] = $client;
                        } else {
                            $this->_routine->add_signal(
                                new signal\Read($this),
                                new event\Read($this->_clients[$_r])
                            );
                        }
                    }
                }
                if (count($write) !== 0) {
                    foreach ($write as $_write) {
                        $this->_routine->add_signal(
                            new signal\Write($this),
                            new event\Write($this->_clients[$_w])
                        );
                    }
                }
            } else {
                // socket error
                \prggmr\throw_socket_error();
            }
        }));
        return true;
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