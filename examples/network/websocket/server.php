<?php
echo '<pre>';
$http =http_parse_headers("GET /chat HTTP/1.1
Host: server.example.com
Upgrade: websocket
Connection: Upgrade
Sec-WebSocket-Key: x3JJHMbDL1EzLkh9GBhXDw==
Sec-WebSocket-Protocol: chat, superchat
Sec-WebSocket-Version: 13
Origin: http://example.com");
var_dump($http);
exit;

xp_import('network');

$connection = network\connect('0.0.0.0', ['port' => 88]);

$connection->on_connect(function($signal){
    $headers = $signal->socket->read();
    var_dump($headers);
    // $signal->socket->disconnect();
});

$connection->on_read(function($signal){
    var_dump($this);
    var_dump(http_parse_headers($signal->socket->read()));
});