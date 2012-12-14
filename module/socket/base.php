<?php
namespace prggmr\socket;
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
     * Socket connection object
     *
     * @var  object
     */
    public $socket = null;

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
    public function __construct(/* ... */)
    {
        parent::__construct();
    }


    /**
     * Establishes the socket connection.
     *
     * @return  void
     */
    abstract protected function _connect(/* ... */);

    /**
     * Reconnects the socket.
     *
     * It will attempt to close before reconnecting.
     *
     * @return  void
     */
    public function reconnect(/* ... */)
    {
        $this->socket->disconnect();
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
}