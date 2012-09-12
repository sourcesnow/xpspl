<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
$dir = dirname(realpath(__FILE__));

/**
 * Autoload the socket signals.
 */
require_once $dir.'/socket.php';
require_once $dir.'/server.php';
require_once $dir.'/connect.php';
require_once $dir.'/disconnect.php';
require_once $dir.'/event/connect.php';
require_once $dir.'/event/disconnect.php';
require_once $dir.'/event/server.php';

