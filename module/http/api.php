<?php
namespace xpspl;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * API can be included to load the entire signal.
 */

use \xpspl\http as http;

/**
 * Attaches a new handle to a URI request.
 *
 * @param  string  $uri  URI of request to handle.
 * @param  object  $function  Closure function to execute
 * @param  string|array  $method  Request method type to handle.
 * @param  object  $event  xpspl\http\Event object
 * 
 * @return  object  xpspl\Handle
 */
function uri_request($uri, $function, $method = null, $event = null) { 
    return \xpspl\handle(new http\Uri(
        $uri, $method, $event
    ), $function);
}