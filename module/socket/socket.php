<?php
namespace prggmr\socket;
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
            \prggmr\throw_socket_error();
        }
        // listen
        socket_listen($this->socket->get_resource());
        \prggmr\socket_set_nonblock($this->socket->get_resource());
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
            $re = $wr = $ex = [];
            $re[] = $this->socket->get_resource();
            foreach ($this->_clients as $_k => $_c) {
                $_r = $_c->get_resource();
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
                            $socket = @socket_accept($_r);
                            if (false === $socket) {
                                continue;
                            }
                            \prggmr\socket_set_nonblock($socket);
                            $connection = new Connection($socket);
                            $this->_routine->add_signal(
                                new signal\Connect($this),
                                new event\Connect($connection)
                            );
                            $this->_clients[$socket] = $connection;
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
