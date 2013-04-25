<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\idle\Process,
    \XPSPL\idle\Time;

/**
 * Base
 *
 * Base signal for a socket.
 */
abstract class Socket_Base extends \XPSPL\signal\Complex {

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
        // Establish the system idle process
    }

    /**
     * Registers the idle process.
     *
     * @return  void
     */
    protected function _register_idle_process(/* ... */)
    {
        $this->_routine->set_idle(new Process(function($processor){
            $idle = $processor->get_routine()->get_idles_available();
            // 30 second default wait
            $time = 30;
            // Determine if another function has requested to execute in x
            // amount of time
            if (count($this->_routine->get_signals()) !== 0) {
                // If we have signals to process only poll and continue
                $time = 0;
            } elseif (count($idle) >= 2) {
                foreach ($idle as $_idle) {
                    if ($_idle instanceof Time) {
                        $time = round($_idle->convert_length(
                            $_idle->get_time_left(), 
                            TIME_SECONDS
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
                    emit(
                        new SIG_Disconnect($this),
                        new EV_Disconnect($_c)
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
                            $client = new Client($_r);
                            $this->_routine->add_signal(
                                new SIG_Connect($this),
                                new EV_Connect($client)
                            );
                            $this->_clients[$client->get_resource()] = $client;
                        } else {
                            $this->_routine->add_signal(
                                new SIG_Read($this),
                                new EV_Read($this->_clients[$_r])
                            );
                        }
                    }
                }
                if (count($write) !== 0) {
                    foreach ($write as $_write) {
                        $this->_routine->add_signal(
                            new SIG_Write($this),
                            new EV_Write($this->_clients[$_w])
                        );
                    }
                }
            } else {
                // socket error
                throw_socket_error();
            }
        }));
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
     * Registers a new handle for disconnections.
     *
     * @param  callable  $function  Function to call on connect.
     *
     * @return  object
     */
    public function on_disconnect($function)
    {
        return signal(new SIG_Disconnect($this), $function);
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
        return signal(new SIG_Read($this), $function);
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
        return signal(new SIG_Write($this), $function);
    }

    /**
     * Registers a new handle for new client connections.
     *
     * @param  callable  $function  Function to call on connect.
     *
     * @return  object
     */
    public function on_client($function)
    {
        return signal(new SIG_Connect($this), $function);
    }

    /**
     * Runs the server routine, this will register the idle function to
     * listen on the given socket.
     *
     * @return  boolean
     */
    public function routine($history = null) 
    {
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