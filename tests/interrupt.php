<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

xp_import('unittest');

unittest\test(function($test){
    $foo = XP_SIG('foo');
    xp_before($foo, function($foo){
        $foo->bar = 'HelloWorld';
    });
    xp_after($foo, function($foo){
        unset($foo->bar);
    });
    xp_signal($foo, function($foo) use ($test) {
        $test->equal($foo->bar, 'HelloWorld');
    });
    xp_emit($foo);
    $test->false(isset($foo->bar));
}, 'Interruptions');