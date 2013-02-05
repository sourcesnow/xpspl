<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

define('UNITTEST_VERSION', 'v1.0.0');

$dir = dirname(realpath(__FILE__)).'/src';
require_once $dir.'/sig_test.php';
require_once $dir.'/sig_suite.php';
require_once $dir.'/output.php';
require_once $dir.'/assertions.php';
require_once $dir.'/api.php';
require_once $dir.'/assertions/default.php';