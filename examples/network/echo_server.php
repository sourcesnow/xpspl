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
xp_import('network');
xp_import('time');

$server = network\connect('0.0.0.0', ['port' => '1337']);

$server->on_connect(xp_null_exhaust(function(network\SIG_Connect $sig_connect){
    if (null !== $sig_connect->socket) {
        echo "Connection " . PHP_EOL;
        echo "Closing connection in 5 seconds".PHP_EOL;
        time\awake(3, function() use ($sig_connect){
            echo "I RAN".PHP_EOL;
            $sig_connect->socket->write('Goodbye');
            $sig_connect->socket->disconnect();
        });
    }
}));