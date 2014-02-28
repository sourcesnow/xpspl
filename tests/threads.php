<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

xp_import('unittest');

class Threaded_Process extends \XPSPL\Process {

    public function execute($signal, $thread = null)
    {
        // var_dump($thread);
        for ($i = 0; $i<1000000000000;$i++) {
            sleep(0.0001 * (mt_rand(5000, 10000)));
            print $i. ' - '.$thread.PHP_EOL;
        }
    }

}

unittest\test(function($test){
    for ($i = 0; $i < 10; $i++) {
        xp_signal(XP_SIG('test'.$i), xp_null_exhaust(xp_threaded_process(new Threaded_Process())));
    }
    for ($i = 0; $i < 10; $i++) {
        xp_emit(XP_SIG('test'.$i));
    }
    // echo '-----------------------------------------------------------------';
    // echo 'DONE EMITTING THEM';
}, "threads");