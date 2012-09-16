<?php
/**
 * Non-Blocking Server
 */
prggmr\load_module('socket');
prggmr\load_module('time');

$server = new prggmr\module\socket\Server("0.0.0.0:1337");

// On Connect
$server->on_connect(function(){
    echo "New Connection".PHP_EOL;
    $this->write("Hello".PHP_EOL);
});

// On Disconnect
$server->on_disconnect(function(){
    echo "Disconnecting".PHP_EOL;
});

// Register the server
// The server must have a null exhaust otherwise it will shutdown after 
// it has handled the number of connections equal to the exhaust
prggmr\handle($server, new prggmr\Handle(function(){
    echo "Server is running at ".$this->get_address().PHP_EOL;
}, null));

prggmr\module\time\interval(15, function(){
    echo "This still works :)";
});