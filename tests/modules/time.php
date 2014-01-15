<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once dirname(realpath(__FILE__)).'/../__init__.php';

import('unittest');
import('time');

unittest\test(function($test){

    $processor = new \XPSPL\Processor();
    $start = time();
    $processor->signal(new \time\SIG_Awake(1, TIME_SECONDS), new \XPSPL\Process(function() use ($start, $test) {
        $test->equal(1, time() - $start);
    }));
    $processor->wait_loop();

}, 'Time Module');