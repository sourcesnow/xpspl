<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


define('NETWORK_VERSION', 'v1.0.0');

$dir = dirname(realpath(__FILE__));

/**
 * Autoload the socket signals.
 */
set_include_path(
    dirname(realpath(__FILE__)) . PATH_SEPARATOR .  get_include_path()
);
require_once $dir.'/api.php';
require_once $dir.'/const.php';
unset($dir);
