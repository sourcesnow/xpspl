<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Performance test.
 */
xp_import('network');

$server = network\connect('0.0.0.0', ['port' => '1337']);

$server->on_connect(xp_null_exhaust(function(network\SIG_Connect $sig_connect){
    $sig_connect->socket->write('HelloWorld');
    $sig_connect->socket->disconnect();
}));

$server->on_error(xp_null_exhaust(function(network\SIG_Error $sig_error){
    echo 'Error : ' . $sig_error->socket->error_str.PHP_EOL;
}));