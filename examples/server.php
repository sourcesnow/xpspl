<?php
/**
 * Non-Blocking Server
 */

$address = "0.0.0.0:5001";

prggmr\load_signal('socket');
prggmr\load_signal('pcntl');
prggmr\load_signal('time');

$server = new prggmr\signal\socket\Server($address);

// On Connect
$server->on_connect(function(){
    echo "New Connection".PHP_EOL;
    $this->write("Hello");
});

// On Disconnect
$server->on_disconnect(function(){
    echo "Disconnecting".PHP_EOL;
    $this->write("Goodbye");
});

// Register the server
prggmr\handle(function(){
    echo "Server is running at ".$this->get_address().PHP_EOL;
}, $server, null, null);
