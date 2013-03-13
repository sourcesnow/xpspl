<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\Idle as idle;

/**
 * Connection
 *
 * Socket connection.
 */
class Connection {

    /**
     * Socket that is connected.
     *
     * @var  resource
     */
    protected $_socket = null;

    /**
     * Read Buffer
     *
     * @var  string|null
     */
    protected $_read_buffer = null;

    /**
     * Read Attempts
     *
     * @var  integer
     */
    protected $_read_attempts = 0;


    /**
     * Constructs a new connection.
     *
     * @param  resource  $socket  Socket connection.
     *
     * @return  void
     */
    public function __construct($socket)
    {
        $this->_socket = $socket;
    }

    /**
     * Returns the socket resource.
     *
     * @return  resource
     */
    public function get_resource(/* ... */)
    {
        return $this->_socket;
    }

    /**
     * Writes data to the socket.
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
                $this->get_resource(), $string, strlen($string), $flags
            );
        }
        return socket_write($this->get_resource(), $string);
    }

    /**
     * Reads the given length of data from the socket.
     *
     * @param  integer  $length  Maximum number of bytes to read in.
     *                           Default = 2MB
     * @param  integer  $flags  See php.net/socket_recv
     *
     * @return  string
     */
    public function read($length = XPSPL_SOCKET_READ_LENGTH, $flags = null) 
    {
        if (null !== $this->_read_buffer) {
            $return = $this->_read_buffer;
            $this->_read_buffer = null;
            return $return;
        }
        $r = null;
        $read = socket_recv($this->get_resource(), $r, $length, $flags);
        if ($read === false) {
            if (socket_last_error($this->get_resource()) == SOCKET_EWOULDBLOCK) {
                if ($this->_read_attempts >= 10) {
                    return false;
                }
                return SOCKET_EWOULDBLOCK;
            }
            return false;
        }
        return $r;
    }

    /**
     * Returns if the socket is currently connected.
     * 
     * @return  boolean
     */
    public function is_connected(/* ... */)
    {
        if (!is_resource($this->get_resource())) {
            return false;
        }
        if (null !== $this->_read_buffer) {
            return true;
        }
        $read = $this->read();
        if (false === $read) {
            return false;
        }
        if ($read === SOCKET_EWOULDBLOCK) {
            ++$this->_read_attempts;
            return true;
        }
        $this->_read_buffer = $read;
        return true;
    }

    /**
     * Send the signal to disconnect this socket.
     *
     * @param  integer  $how
     *
     * @return  event\Disconnect
     */
    public function disconnect(/* ... */)
    {
        return emit(
            new SIG_Disconnect(), 
            new EV_Disconnect($this)
        );
    }

    /**
     * Returns the address of the socket.
     *
     * @return  string|null
     */
    public function get_address(/* ... */)
    {
        $r = null;
        /**
         * This is documented as stating this should only be used
         * for socket_connect'ed sockets ... for now this seems to work.
         */
        socket_getsockname($this->get_resource(), $r);
        return $r;
    }

    /**
     * Establishes the socket connection.
     *
     * @return  void
     */
    protected function _connect(/* ... */) {
        throw new \RuntimeException;
    }
}

/**
 * Disconnects a socket signal.
 *
 * @param  object  $event  event\Disconnect
 * 
 * @return  void
 */
function sys_disconnect(EV_Disconnect $event) 
{
    echo "CLOSING THE CONNECTION";
    socket_close($event->socket->get_resource());
}

/**
 * Register the disconnect
 *
 * This fires as a last priority to allow pushing content to the host.
 *
 * Though it should be noted that pushing content to a disconnected socket might 
 * not get the data.
 */
signal(
    new SIG_Disconnect(), 
    low_priority(null_exhaust('\network\sys_disconnect'))
);
