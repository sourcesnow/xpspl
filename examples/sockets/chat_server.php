<?php

prggmr\load_module('socket');

$socket = prggmr\socket('0.0.0.0', ['port' => '1337'], function(){
    var_dump($this);
    echo "Running on " . $this->get_address();
});

var_dump($socket);

$socket->on_connect(function(){
    echo "New Connection";
});