<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

unittest\test(function($test){
    for ($i = 0; $i < 1000; $i++) {
        signal(SIG('test'.$i), null_exhaust(threaded_process(function(){
            sleep(60);
            for ($i = 0; $i<10000000;$i++) {
                print $i.PHP_EOL;
            }
        })));
    }
    for ($i = 0; $i < 1000; $i++) {
        emit(SIG('test'.$i));
    }
}, "threads");