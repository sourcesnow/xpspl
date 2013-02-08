<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
import('unittest');

unittest\suite(function($suite){

    $suite->test(function($test){
        $test->exception('InvalidArgumentException', function(){
            $process = new XPSPL\Process(null);
        });
        $process = new XPSPL\Process(function(){}, 'a');
        $test->equal($process->exhaustion(), 1);
        $process = new XPSPL\Process(function(){}, -1);
        $test->equal($process->exhaustion(), 1);
    }, "process construction");

    $suite->test(function($test){
        $process = new XPSPL\Process(function(){});
        $test->false($process->is_exhausted());
        $process->decrement_exhaust();
        $test->true($process->is_exhausted());
        $process = new XPSPL\Process(function(){}, 2);
        $process->decrement_exhaust();
        $test->false($process->is_exhausted());
        $process->decrement_exhaust();
        $test->true($process->is_exhausted());
        $process = new XPSPL\Process(function(){}, null);
        for ($i=0;$i!=5;$i++) { $process->decrement_exhaust(); }
        $test->false($process->is_exhausted());
        $process = new XPSPL\Process(function(){}, 0);
        $test->true($process->is_exhausted());
    }, "Process exhaustion");

});