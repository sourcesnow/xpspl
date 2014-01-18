<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once dirname(realpath(__FILE__)).'/../__init__.php';

xp_import('unittest');

unittest\test(function($test){
    $foo = XP_SIG('foo');
    xp_signal($foo, null);
    $test->instanceof(xp_find_signal_database($foo), 'XPSPL\database\Processes');
});