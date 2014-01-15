<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


define('NETWORK_VERSION', 'v1.0.0');

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
$files = [
    'sig_base','sig_connect','sig_disconnect','sig_read','sig_write',
    'connection','client','socket'
];
foreach ($files as $_f) {
    require_once dirname(realpath(__FILE__)) . '/' . $_f . '.php';
}
require_once $dir.'/api.php';
require_once $dir.'/const.php';
unset($dir);
