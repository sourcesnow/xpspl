<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Chat Server
 *
 * This example demonstrates how to build a simple TCP chat server which can
 * be connected using telnet.
 */
xp_import('network');

$socket = network\connect('0.0.0.0', ['port' => '8000'], function(){
    echo "Server Running on " . $this->socket->get_address() . PHP_EOL;
});

$socket->on_connect(function(network\SIG_Connect $sig_connect) use ($socket){
    $sig_connect->socket->write("Welcome to the prggmr chat server".PHP_EOL);
    $sig_connect->socket->write("Enter your username : ");
});
$socket->on_read(null);
$socket->on_read(function(network\SIG_Read $sig_read) use ($socket){
    $clients = $socket->get_connections();
    $client = $clients[intval($sig_read->socket->get_resource())];
    // Strip any newlines from linux
    $sig_read->socket->_read_buffer();
    $content = implode("", explode("\r\n", $sig_read->socket->read()));
    // windows
    $content = implode("", explode("\n\r", $content));
    // On first connection read in the username
    if (!isset($client->username)) {
        $client->username = $content;
        $sig_read->socket->write("Welcome $content".PHP_EOL);
        foreach ($clients as $_client) {
            if ($_client != $sig_read->socket) {
                $_client->write(sprintf(
                    '%s has connected'.PHP_EOL,
                    $content
                ));
            }
        }
        $connected = [];
        foreach ($clients as $_client) {
            if (isset($_client->username)) {
                $connected[] = $_client->username;
            }
        }
        $sig_read->socket->write(sprintf(
            "%s User Online (%s)".PHP_EOL,
            count($connected),
            implode(", ", $connected)
        ));
    } else {
        foreach ($clients as $_client) {
            if ($_client != $sig_read->socket) {
                $_client->write(sprintf(
                    '%s : %s'.PHP_EOL,
                    $client->username,
                    $content
                ));
            }
        }
    }
});

$socket->on_disconnect(function() use ($socket){
    $clients = $socket->get_clients();
    $client = $clients[$sig_read->socket->get_resource()];
    foreach ($clients as $_client) {
        if ($_client != $sig_read->socket) {
            $_client->write(sprintf(
                '%s Disconnected'.PHP_EOL,
                $client->username
            ));
        }
    }
});