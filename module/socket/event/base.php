<?php
namespace xpspl\socket\event;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

if (!defined('XPSPL_SOCKET_READ_LENGTH')) {
    define('XPSPL_SOCKET_READ_LENGTH', 1048576);
}

/**
 * Base
 * 
 * Base socket event for reading/writing and disconnecting a socket.
 */
abstract class Base extends \xpspl\Event {

    /**
     * Socket connection object
     *
     * @var  object
     */
    public $socket = null;

    /**
     * Constructs a new socket event.
     *
     * @param  object  $socket  Socket connection object
     * @param  integer|null  $ttl  Time to live
     *
     * @return  void
     */
    public function __construct($socket, $ttl = null)
    {
        $this->socket = $socket;
        return parent::__construct($ttl);
    }
}