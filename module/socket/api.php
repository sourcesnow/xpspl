<?php
namespace xpspl;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Creates a new socket.
 *
 * @param  string  $address  Address to make the connection on.
 * @param  string  $options  Connection options
 * @param  callback  $callback  Function to call when connected
 */
function socket($address, $options = [], $callback = null)
{
    $server = new socket\Socket($address, $options);

    if (null === $callback) {
        $callback = function(){};
    }

    handle($server, $callback);

    return $server;
}

/**
 * Throws a runtime exception of the last socket error
 *
 * @throws  RuntimeException
 * 
 * @return  void
 */
function throw_socket_error() {
    $code = socket_last_error();
    $str = socket_strerror($code);
    throw new \RuntimeException(sprintf(
        '(%s) - %s',
        $code, $str
    ));
}

/**
 * Sets a socket as non-blocking and defines other global options.
 *
 * This function has been abstracted for any applicable options that will be
 * set system wide.
 */
function socket_set_nonblock($socket) {
    // force non-blocking
    \socket_set_nonblock($socket);
    // disconnect without waiting
    // \socket_set_option(
    //     $socket, SOL_SOCKET, SO_LINGER, [
    //         'l_onoff' => 0, 'l_linger' => 0
    //     ]
    // );
}