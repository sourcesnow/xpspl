<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

xp_import('unittest');
xp_import('time');


class Threaded_Process extends \XPSPL\Process
{
    public function execute($signal, $thread = null)
    {
        // Just count
        for ($i = 0; $i<10000000;$i++) {
            echo $i;
        }
    }
}

unittest\test(function($test){
    for ($i = 0; $i < 16; $i++) {
        xp_signal(XP_SIG('test'.$i), xp_threaded_process(new Threaded_Process()));
    }
    for ($i = 0; $i < 16; $i++) {
        xp_emit(XP_SIG('test'.$i));
    }
}, "threads");