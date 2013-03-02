<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * SIG
 * 
 * Base socket signal.
 */
class SIG extends \XPSPL\SIG {

    /**
     * Socket associated with the signal.
     *
     * @var  object  \network\Socket
     */
    protected $_socket = null;
    

    /**
     * Socket signals use the connection and socket hash
     *
     * @param  string|integer  $info  Signal information
     * @param  object  $socket  \network\Socket
     * 
     * @return  void
     */
    public function __construct($info = null, Socket $socket = null)
    {
        if (null === $info) {
            parent::__construct();
            return;
        }
        if (null !== $socket) {
            $this->_socket = $socket;
        }
        $this->_info = spl_object_hash($info).'.'.get_class($this);
    }

    /**
     * Sets the signals socket.
     *
     * @param  object  $socket  \network\Socket
     *
     * @return  void
     */
    public function set_socket(Socket $socket)
    {
        $this->_socket = $socket;
    }

    /**
     * Gets the signals socket.
     *
     * @return  object  \network\Socket
     */
    public function get_socket(/* ... */)
    {
        return $this->_socket;
    }
}