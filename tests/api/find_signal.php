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
    xp_register_signal($foo);
    $test->instanceof(xp_get_signal($foo), 'XPSPL\database\Processes');
}, 'API Find signal database');