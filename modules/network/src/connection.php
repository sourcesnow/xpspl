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
    protected $_resource = null;

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
signal(
    new SIG_Disconnect(), 
    low_priority(null_exhaust('\network\sys_disconnect'))
);