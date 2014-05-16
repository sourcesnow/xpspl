.. time::

Network Module
--------------

The Network module provides non-blocking signal driven I/O.

Installation
____________

The network Module is bundled with XPSPL.

Requirements
%%%%%%%%%%%%

PHP
^^^

PHP Sockets_ extension must be installed and enabled.

.. _Sockets: http://us1.php.net/manual/en/book.sockets.php

XPSPL
^^^^^

XPSPL **>= 3.0**

Configuration
_____________

The Network Module has no runtime configuration options available.

API
___

.. function:: network\\connect($address, [$options = array()])


    Creates a new socket connection.
    
    Connection options.
    
    * **port** - Default: null
    * **domain** - Default: AF_INET
    * **type** - Default: SOCK_STREAM
    * **protocol** - Default: SOL_TCP

    :param string: Address to make the connection on.
    :param string: Connection options
    :param callback: Function to call when connected

    :rtype: object \network\Socket

Usage
_____

Importing
^^^^^^^^^

.. code-block:: php

    <?php

    xp_import('network');

Basic Server
^^^^^^^^^^^^

This demonstrates a basic network server that recieves connections on port 8000
sends "HelloWorld" to the connection and disconnects.


.. code-block:: php

    <?php

    xp_import('network');

    $conn = network\connect('127.0.0.1', ['port' => 8000]);

    $conn->on_connect(function($signal){
        $signal->socket->write('HelloWorld');
        $signal->socket->disconnect();
    });

Chat Server
^^^^^^^^^^^

.. code-block:: php
    
    <?php

    xp_import('network');

    $socket = network\connect('0.0.0.0', ['port' => '8000'], function(){
        echo "Server Running on " . $this->socket->get_address() . PHP_EOL;
    });

    $socket->on_connect(function(network\SIG_Connect $sig_connect) use ($socket){
        $sig_connect->socket->write("Welcome to the chat server".PHP_EOL);
        $sig_connect->socket->write("Enter your username : ");
    });
    $socket->on_read(null);
    $socket->on_read(function(network\SIG_Read $sig_read) use ($socket){
        $clients = $socket->get_connections();
        $client = $clients[intval($sig_read->socket->get_resource())];
        // Strip any newlines from linux
        $sig_read->socket->_read_buffer();
        $content = implode("", explode("\r\n", $sig_read->socket->read()));
        // windows
        $content = implode("", explode("\n\r", $content));
        // On first connection read in the username
        if (!isset($client->username)) {
            $client->username = $content;
            $sig_read->socket->write("Welcome $content".PHP_EOL);
            foreach ($clients as $_client) {
                if ($_client != $sig_read->socket) {
                    $_client->write(sprintf(
                        '%s has connected'.PHP_EOL,
                        $content
                    ));
                }
            }
            $connected = [];
            foreach ($clients as $_client) {
                if (isset($_client->username)) {
                    $connected[] = $_client->username;
                }
            }
            $sig_read->socket->write(sprintf(
                "%s User Online (%s)".PHP_EOL,
                count($connected),
                implode(", ", $connected)
            ));
        } else {
            foreach ($clients as $_client) {
                if ($_client != $sig_read->socket) {
                    $_client->write(sprintf(
                        '%s : %s'.PHP_EOL,
                        $client->username,
                        $content
                    ));
                }
            }
        }
    });

    $socket->on_disconnect(function() use ($socket){
        $clients = $socket->get_clients();
        $client = $clients[$sig_read->socket->get_resource()];
        foreach ($clients as $_client) {
            if ($_client != $sig_read->socket) {
                $_client->write(sprintf(
                    '%s Disconnected'.PHP_EOL,
                    $client->username
                ));
            }
        }
    });    