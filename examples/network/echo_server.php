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
import('network');

$server = network\connect('0.0.0.0', ['port' => '1337']);

$server->on_connect(null_exhaust(function($sig_connect){
    var_dump($sig_connect);
    if (null !== $sig_connect->socket) {
        echo "Connection " . PHP_EOL;
        $sig_connect->socket->write($sig_connect->socket->read());
        $sig_connect->socket->disconnect();
    }
}));