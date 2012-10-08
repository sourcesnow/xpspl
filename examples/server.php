<?php
/**
 * Non-Blocking Server
 */
prggmr\load_module('socket');
prggmr\load_module('time');

$server = new prggmr\module\socket\server\Select("0.0.0.0:1337");

// On Connect
$server->on_connect(new prggmr\Handle(function(){
    $data_in = $this->read();
    echo $data_in;
    $this->write("Hello".PHP_EOL);
    $this->write("You sent me the following".PHP_EOL);
    $this->write($data_in);
}, null));

// // On Disconnect
$server->on_disconnect(new prggmr\Handle(function(){
    echo "Disconnecting".PHP_EOL;
}, null));

// Register the server
// The server must have a null exhaust otherwise it will shutdown after 
// it has handled the number of connections equal to the exhaust
prggmr\handle($server, new prggmr\Handle(function(){
    echo "Server is running at ".$this->get_address().PHP_EOL;
}, null));

prggmr\module\time\interval(10, function(){
    echo "10 seconds goes by...".PHP_EOL;
}, prggmr\engine\idle\Time::SECONDS);