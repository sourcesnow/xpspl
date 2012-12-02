<?php
/**
 * Non-Blocking Server
 */
prggmr\load_module('socket');
prggmr\load_module('time');

$server = new prggmr\module\socket\server\Select("0.0.0.0:1337");

// On Connect
$server->on_connect(new prggmr\Handle(function(){
    var_dump($this->get_socket());
    if (!isset($this->count)) {
        $this->count = 0;
    } else {
        $this->count++;
        if ($this->count() >= 500) {
            $this->get_socket()->reconnect();
        }
        echo $this->count.PHP_EOL;
    }
    $this->write("You sent me the following".PHP_EOL);
    $this->write($this->read());
}, null));

// // On Disconnect
$server->on_disconnect(new prggmr\Handle(function(){
    echo "Disconnecting".PHP_EOL;
}, null));

// Register the server
prggmr\handle($server, function(){
    echo "Server is running at ".$this->get_address().PHP_EOL;
});

prggmr\module\time\interval(10, function(){
    echo "10 seconds goes by...".PHP_EOL;
}, prggmr\engine\idle\Time::SECONDS);