<?php
/**
 * Non-Blocking Server
 */

$address = "127.0.0.1:5000";

prggmr\load_signal('socket');
prggmr\load_signal('pcntl');
prggmr\load_signal('time');

$server = new prggmr\signal\socket\Server("127.0.0.1:5000");

prggmr\handle(function(){}, $server, null, 0);

// Handle a new connection
prggmr\handle(function(){
    $socket = $this->get_signal()->get_socket();
    // stream_socket_sendto($socket, "Hello".PHP_EOL);
    stream_socket_shutdown($socket, STREAM_SHUT_RDWR);
}, new prggmr\signal\socket\Connection(), null, null);

echo "Server is running at $address".PHP_EOL;