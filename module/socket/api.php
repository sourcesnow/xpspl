<?php
namespace prggmr;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \prggmr\module\socket\Socket;

/**
 * Creates a new socket.
 *
 * @param  string  $address  Address to make the connection on.
 * @param  string  $options  Connection options
 * @param  callback  $callback  Function to call when connected
 */
function socket($address, $options = [], $callback = null)
{
    $server = new Socket($address, $options);

    if (null === $callback) {
        $callback = function(){};
    }

    handle($server, $callback);

    return $server;
}