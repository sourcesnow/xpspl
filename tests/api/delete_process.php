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
    $foo = XP_SIG('foo');
    $process = xp_process(null);
    xp_signal($foo, $process);
    xp_delete_process($foo, $process);
    xp_emit($foo);
    $test->exception('LogicException', function() use ($foo){
        echo $foo->foo;
    });
});