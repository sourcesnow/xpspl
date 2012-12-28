<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Echo Server
 *
 * This example demonstrates a simple echo server that spits back anything that
 * was sent and then disconnects.
 */
import('socket');

$socket = prggmr\socket('0.0.0.0', ['port' => '80'], function(){
    echo "Server Running on " . $this->socket->get_address() . PHP_EOL;
});

$socket->on_connect(function(){
    echo "Connection " . PHP_EOL;
    $this->socket->write($this->socket->read());
    $this->socket->disconnect();
});