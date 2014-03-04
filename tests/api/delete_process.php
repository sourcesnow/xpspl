<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once dirname(realpath(__FILE__)).'/../__init__.php';

xp_import('unittest');

/**
 * Emit Unitest
 */
unittest\test(function($test){
    $foo = XP_SIG(spl_object_hash(new stdClass()));
    $process = xp_process(null);
    xp_signal($foo, $process);
    xp_delete_process($foo, $process);
    $test->count(xp_find_signal_database($foo), 0);
}, 'API Delete Process');