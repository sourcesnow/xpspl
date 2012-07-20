<?php
/**
 * Non-Blocking Server
 */

$address = "0.0.0.0:5001";

prggmr\load_signal('socket');
prggmr\load_signal('pcntl');
prggmr\load_signal('time');

$server = new prggmr\signal\socket\Server($address);

// Register the server
prggmr\handle(function(){}, $server, null, 0);

// Handle a new connection
prggmr\handle(function(){
    echo "Client connected".PHP_EOL;
    // Write to it
    $this->write("HelloWorld".PHP_EOL);
    $this->disconnect();
}, $server->on_connect(), null, null);

/**
 * Handle a disconnect.
 *
 * This only allows for handling the disconnect after it has disconnected.
 */
prggmr\handle(function(){
    echo "Client disconnected".PHP_EOL;
}, $server->on_disconnect(), null, null);

echo "Server is running at $address".PHP_EOL;
