<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Creates a new socket connection.
 *
 * @param  string  $address  Address to make the connection on.
 * @param  string  $options  Connection options
 * @param  callback  $callback  Function to call when connected
 */
function connect($address, $options = [])
{
    $socket = new Socket($address, $options);
    signal($socket, null_exhaust(null));
    return $socket;
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
    throw new \RuntimeException(sprintf(
        '(%s) - %s',
        $code, socket_strerror($code)
    ));
}