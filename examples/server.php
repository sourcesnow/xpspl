<?php
/**
 * Non-Blocking Server
 */
prggmr\load_signal('socket');

$server = new prggmr\signal\socket\Server("0.0.0.0:1337");

// On Connect
$server->on_connect(function(){
    echo "New Connection".PHP_EOL;
    $this->write("Hello".PHP_EOL);
});

// On Disconnect
$server->on_disconnect(function(){
    echo "Disconnecting".PHP_EOL;
    $this->write("Goodbye".PHP_EOL);
});

// Register the server
prggmr\handle(function(){
    echo "Server is running at ".$this->get_address().PHP_EOL;
}, $server);
