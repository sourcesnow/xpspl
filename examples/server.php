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
    echo "New client connection".PHP_EOL;
    // Get the socket
    $socket = $this->get_signal();
    // Read from it
    $rec = $socket->read();
    $socket->write("Your HTTP Headers " . PHP_EOL . $rec . PHP_EOL);
    // Write to it
    $socket->write("HelloWorld".PHP_EOL);
    // And close it
    $socket->close();
}, $server->connect(), null, null);

echo "Server is running at $address".PHP_EOL;
