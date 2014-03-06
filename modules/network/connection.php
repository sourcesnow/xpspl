<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

xp_import('time');

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
    protected $_read_attempted = 0;

    /**
     * Error encountered on the socket.
     *
     * @var  string
     */
    public $error = null;

     /**
     * Error encountered on the socket.
     *
     * @var  string
     */
    public $error_str = null;

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
     * Reads the given length of data from the socket into the read buffer.
     *
     * @param  integer  $length  Maximum number of bytes to read in.
     *                           Default = 2MB
     * @param  integer  $flags  See php.net/socket_recv
     *
     * @return  string
     */
    public function _read_buffer($length = XPSPL_SOCKET_READ_LENGTH, $flags = MSG_DONTWAIT)
    {
        $r = null;
        $read = @socket_recv($this->get_resource(), $r, $length, $flags);
        if ($read === 0) {
            return false;
        }
        if ($read === false) {
            $error = socket_last_error($this->get_resource());
            $this->error = $error;
            $this->error_str = socket_strerror($this->error);
            // Non-blocking IO
            if ($error == SOCKET_EWOULDBLOCK || $error = SOCKET_EAGAIN) {
                ++$this->_read_attempted;
                return true;
            }
            return false;
        }
        $this->_read_attempted = 0;
        if ($r !== null) {
            if (null === $this->_read_buffer) {
                $this->_read_buffer = trim($r);
            } else {
                $this->_read_buffer .= trim($r);
            }
        }
        return true;
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
        // peek into the connection reading 1 byte ... this works only
        // when there is data to read on the connection
        if (false === $this->_read_buffer(1, MSG_DONTWAIT ^ MSG_PEEK)) {
            return false;
        }
        // try and read data waiting on the connection into the buffer.
        $this->_read_buffer();
        $error = socket_get_option($this->get_resource(), SOL_SOCKET, SO_ERROR);
        if ($error !== 0) {
            $this->error = socket_last_error($this->get_resource());
            $this->error_str = socket_strerror($this->error);

            return false;
        }
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
        return xp_emit(new SIG_Disconnect(null, $this));
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

    /**
     * Read data from the socket.
     *
     * @return  void
     */
    public function read($length = XPSPL_SOCKET_READ_LENGTH, $start = 0) {
        return substr($this->_read_buffer, $start, $length);
    }

    /**
     * Flushes the read buffer.
     *
     * @return  void
     */
    public function flush_read_buffer(/* ... */) {
        $this->_read_buffer = null;
    }
}

/**
 * Disconnects a socket signal.
 *
 * @param  object  $sig_disconnect  \network\SIG_Disconnect
 *
 * @return  void
 */
function system_disconnect(SIG_Disconnect $sig_disconnect)
{
    if (is_resource($sig_disconnect->socket->get_resource())) {
        socket_close($sig_disconnect->socket->get_resource());
    }
}

/**
 * Flushes the read buffer at the end of the cycle.
 *
 * This makes data available from the ``read`` method.
 *
 * @return  void
 */
function clean_buffer(SIG_Read $sig_read)
{
    $sig_read->socket->flush_read_buffer();
}


/**
 * Register the disconnect
 *
 * This fires as a last priority to allow pushing content to the host.
 *
 * Though it should be noted that pushing content to a disconnected socket might
 * not get the data.
 */
xp_signal(
    new SIG_Disconnect(),
    xp_low_priority(xp_null_exhaust('\network\system_disconnect'))
);