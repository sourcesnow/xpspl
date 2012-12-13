<?php

prggmr\load_module('socket');

$socket = prggmr\socket('0.0.0.0', ['port' => '1337'], function(){
    echo "Running on " . $this->get_address();
});


$socket->on_connect(function(){
    echo "New Connection";
});

$socket->on_read(function(){
    $this->write($this->read());
});