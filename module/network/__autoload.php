<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
$dir = dirname(realpath(__FILE__));

if (!defined('XPSPL_NETWORK_TIMEOUT_MICROSECONDS')) {
    define('XPSPL_NETWORK_TIMEOUT_MICROSECONDS', 0);
}

if (!defined('XPSPL_NETWORK_TIMEOUT_SECONDS')) {
    define('XPSPL_NETWORK_TIMEOUT_SECONDS', 15);
}

/**
 * Autoload the socket signals.
 */
require_once $dir.'/src/api.php';
set_include_path(
    dirname(realpath(__FILE__)).'/src' .
    PATH_SEPARATOR . 
    get_include_path()
);
