<?php
namespace prggmr\signal\http\api;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * API can be included to load the entire signal.
 */

use \prggmr\signal\http as http;

/**
 * Attaches a new handle to a URI request.
 *
 * @param  string  $uri  URI of request to handle.
 * @param  object  $function  Closure function to execute
 * @param  string|array  $method  Request method type to handle.
 * @param  object  $event  prggmr\signal\http\Event object
 * @param  integer|null  $priority  Handle priority
 * @param  integer|null  $exhaust  Handle exhaust rate.
 * 
 * @return  object  prggmr\Handle
 */
function uri_request($uri, $function, $method = null, $event = null, $priority = null, $exhaust = 1) { 
    return \prggmr\handle(new http\Uri(
        $uri, $method, $event
    ), $function, $priority, $exhaust);
}