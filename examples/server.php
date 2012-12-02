<?php
/**
 * Non-Blocking Server
 */
prggmr\load_module('socket');
prggmr\load_module('time');

$server = new prggmr\module\socket\server\Select("0.0.0.0:1337");

// On Connect
$server->on_connect(new prggmr\Handle(function(){
    $server = $this->get_server();
    if (!isset($this->server->count)) {
        $this->server->count = 0;
    } else {
        echo $this->server->count.PHP_EOL;
        $this->server->count++;
        if ($this->server->count >= 500) {
            // If more than 500 after this
            prggmr\after($this->get_signal(), function() use ($server){
                $server->reconnect();
                $server->count = 0;
            });
        }
        echo $this->server->count.PHP_EOL;
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