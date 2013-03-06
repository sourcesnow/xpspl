<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Socket
 *
 * The Socket represents a low-level socket.
 */
class Socket {

    /**
     * Socket Address
     *
     * @var  string
     */
    protected $_address = null;

    /**
     * Construct a new socket.
     *
     * An address can be provided using a connection string,
     *
     * tcp://0.0.0.0:8000
     * udp://0.0.0.0:8000
     *
     * OR by providing the parameters manually
     *
     * __construct('0.0.0.0', [
     *     'port' => 8000,
     *     'type' => SOL_TCP,
     *     'type' => SOCK_STREAM,
     *     'domain' => AF_INET
     * ])
     *
     * @param  string  $address  Address to make the connection on.
     * @param  string  $options  Connection options
     *
     * @return  void
     */
    public function __construct($address, $options = [])
    {
        parent::__construct();

        if (stripos('://', $address) !== false) {
            $address = explode('://', $address);
            $options['protocol'] = (
                $address[0] === 'tcp'
            ) ? SOL_TCP : SOL_UDP;
            $address = $address[1];
        }

        if (stripos(':', $address) !== false) {
            $address = explode(":", $address);
            $options['port'] = $address[1];
            $address = $address[0];
        }

        if (isset($options['protocol']) && !isset($options['type'])) {
            switch ($options['protocol']) {
                case SOL_TCP:
                    $options['type'] = SOCK_STREAM;
                    break;
                case SOL_UDP:
                    $options['type'] = SOCK_DGRAM;
                    break;
            }
        }

        $defaults = [
            'domain' => (XPSPL_NETWORK_IPV6) ? AF_INET6 : AF_INET,
            'type' => SOCK_STREAM,
            'protocol' => SOL_TCP
        ];

        $options += $defaults;

        $this->_address = $address;
        $this->_options = $options;

        $this->_connect();
    }

    /**
     * Establishes the socket connection.
     *
     * @return  void
     */
    protected function _connect(/* ... */)
    {
        // Establish a connection
        $this->_resource = socket_create(
            $this->_options['domain'], 
            $this->_options['type'], 
            $this->_options['protocol']
        );
        // timeout
        socket_set_option(
            $this->_resource, 
            SOL_SOCKET, 
            SO_RCVTIMEO,
            [
                'sec' => XPSPL_NETWORK_TIMEOUT_SECONDS, 
                'usec' => XPSPL_NETWORK_TIMEOUT_MICROSECONDS
            ]
        );
        $bind = socket_bind(
            $this->_resource, 
            $this->_address, 
            $this->_options['port']
        );
        if (false === $bind) {
            throw_socket_error();
        }
        // listen
        socket_listen($this->_resource);
        socket_set_nonblock($this->_resource);
        emit(new SIG_Connect($this));
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
                $this->_resource, $string, strlen($string), $flags
            );
        }
        return @socket_write($this->_resource, $string);
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
                $this->_resource, $r, $length, $flags)) {
                return $r;
            }
            return false;
        }
        return @socket_read($this_resource, $length, $flags);
    }

    /**
     * Disconnects the socket.
     *
     * @param  integer  $how
     *
     * @return  event\Disconnect
     */
    public function disconnect(/* ... */)
    {
        emit(new SIG_Disconnect($this));
        @socket_close($this->_resource);
    }

    /**
     * Returns the socket resource.
     *
     * @return  resource
     */
    public function get_resource(/* ... */)
    {
        return $this->_resource;
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
}
