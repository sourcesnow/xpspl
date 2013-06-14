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
import('time');

$server = network\connect('0.0.0.0', ['port' => '1337']);

$server->on_connect(null_exhaust(function(network\SIG_Connect $sig_connect){
    if (null !== $sig_connect->socket) {
        echo "Connection " . PHP_EOL;
        $sig_connect->socket->write('HelloWorld');
        $sig_connect->socket->write('Closing connection in 5 seconds');
        time\awake(5, function() use ($sig_connect){
            $sig_connect->socket->write('Goodbye');
            $sig_connect->socket->disconnect();
        });
    }
}));