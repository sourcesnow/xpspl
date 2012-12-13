<?php
namespace prggmr\module\socket;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Base
 *
 * Base signal for a socket.
 */
abstract class Base extends \prggmr\signal\Complex {

    /**
     * Signal dispatched when a new connection is made.
     *
     * @var  object
     */
    protected $_on_connect = null;

    /**
     * Signal dispatched when a socket connection is lost.
     *
     * @var  object
     */
    protected $_on_disconnect = null;

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
     * Constructs a new socket
     */
    public function __construct()
    {
        $this->_on_connect = new signal\Connect();
        $this->_on_disconnect = new signal\Disconnect();
        parent::__construct();
    }


    /**
     * Establishes the socket connection.
     *
     * @return  void
     */
    abstract protected function _connect(/* ... */);

    /**
     * Disconnects from the socket.
     *
     * @return  void
     */
    abstract public function disconnect(/* ... */);

    /**
     * Reconnects the socket.
     *
     * It will attempt to close before reconnecting.
     *
     * @return  void
     */
    public function reconnect(/* ... */)
    {
        $this->disconnect();
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
            $this->_on_disconnect, $function
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
            $this->_on_connect, $function
        );
    }
}