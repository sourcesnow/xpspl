<?php
namespace prggmr\module\socket\event;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

if (!defined('PRGGMR_SOCKET_READ_LENGTH')) {
    define('PRGGMR_SOCKET_READ_LENGTH', 1048576);
}

/**
 * Base
 * 
 * Base socket event for reading/writing and disconnecting a socket.
 */
abstract class Base extends \prggmr\Event {

    /**
     * Socket resource event represents.
     *
     * @var  resource
     */
    protected $_socket = null;

    /**
     * Constructs a new socket event.
     *
     * @param  resource  $socket  Socket that connected
     * @param  integer|null  $ttl  Time to live
     *
     * @return  void
     */
    public function __construct($socket, $ttl = null)
    {
        $this->_socket = $socket;
        $this->_server = $server;
        return parent::__construct($ttl);
    }

    /**
     * Returns the socket resource.
     *
     * @return  resource
     */
    public function get_socket(/* ... */)
    {
        return $this->_socket;
    }

    /**
     * Returns the socket signal this event originated from.
     *
     * @return  object
     */
    public function get_socket_signal(/* ... */)
    {
        return prggmr\current_signal(-1);
    }

    /**
     * Writes data to a socket.
     *
     * @param  string  $string  String to send.
     * @param  integer  $flags  Send flags - php.net/socket_send
     *
     * @return  integer|boolean  Number of bytes written, False on error
     */
    public function write($string, $flags = null)
    {
        if ($flags !== null) {
            return socket_send(
                $this->get_socket(), $string, strlen($string), $flags
            );
        }
        return socket_write($this->get_socket(), $string);
    }

    /**
     * Reads the given length of data from a socket.
     *
     * @param  integer  $length  Maximum number of bytes to read in.
     *                           Default = 2MB
     * @param  integer  $flags  See php.net/socket_recv
     *
     * @return  string
     */
    public function read($length = PRGGMR_SOCKET_READ_LENGTH, $flags = null) 
    {   
        if (null !== $flags) {
            $r = null;
            if (false !== socket_recv(
                $this->get_socket(), $r, $length, $flags)) {
                return $r;
            }
            return false;
        }
        return socket_read($this->get_socket(), $length, $flags);
    }

    /**
     * Send the signal to disconnect this socket.
     *
     * @param  integer  $how
     *
     * @return  void
     */
    public function disconnect(/* ... */)
    {
        $this->get_socket_signal()->send_disconnect($this->get_socket());
    }

    /**
     * Returns the address of the socket.
     *
     * @return  string|null
     */
    public function get_address(/* ... */)
    {
        $r = null;
        var_dump($this->get_socket());
        socket_getpeername($this->get_socket(), $r);
        return $r;
    }
}