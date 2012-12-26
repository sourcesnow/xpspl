<?php
namespace xpspl\socket;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \xpspl\engine\idle as idle,
    \xpspl\Handle;

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
            return @socket_send(
                $this->get_resource(), $string, strlen($string), $flags
            );
        }
        return @socket_write($this->get_resource(), $string);
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
        if (null !== $flags) {
            $r = null;
            if (false !== @socket_recv(
                $this->get_resource(), $r, $length, $flags)) {
                return $r;
            }
            return false;
        }
        return @socket_read($this->get_resource(), $length, $flags);
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
        return \xpspl\signal(
            new signal\Disconnect(), 
            new event\Disconnect($this)
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
        @socket_getsockname($this->get_resource(), $r);
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
function on_disconnect(event\Disconnect $event) 
{
    @socket_close($event->socket->get_resource());
}

/**
 * Register the disconnect
 *
 * This fires as a last priority to allow pushing content to the host.
 *
 * Though it should be noted that pushing content to a disconnected socket might 
 * not get the data.
 */
\xpspl\handle(
    new signal\Disconnect(), 
    new Handle('\xpspl\socket\on_disconnect', null, PHP_INT_MAX)
);