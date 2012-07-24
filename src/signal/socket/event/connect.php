<?php
namespace prggmr\signal\socket\event;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Socket connection event.
 */
class Connect extends \prggmr\Event {
    
    use \prggmr\signal\socket\Socket;

    /**
     * The signal stream that opened this connection.
     *
     * @param  object
     */
    public $signal_stream = null;

    /**
     * Constructs a new connection event.
     *
     * @param  resource  $socket  Socket that connected
     * @param  integer|null  $ttl  Time to live
     *
     * @return  void
     */
    public function __construct($socket, $signal_stream, $ttl = null)
    {
        $this->signal_stream = $signal_stream;
        $this->_socket = $socket;
        return parent::__construct($ttl);
    }

    /**
     * Signals the disconnection of this socket.
     *
     * @param  integer  $how
     *
     * @return  void
     */
    public function disconnect($how = STREAM_SHUT_RDWR)
    {
        $this->signal_stream->send_disconnect($this->get_socket());
    }

    /**
     * Returns the server.
     */
}