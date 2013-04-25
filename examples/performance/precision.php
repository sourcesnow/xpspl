<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
import('time');
/**
 * TODO: Change awake to wait.
 */
// time\awake(30, null_exhaust(function(){}), TIME_MICROSECONDS);
for ($i=0;$i<PHP_INT_MAX;++$i) {
    echo .000001 * gettimeofday()['usec'];
    echo PHP_EOL;
    echo explode(" ", microtime())[0];
    echo PHP_EOL;
    // print floatval(time());
    // echo PHP_EOL;
    // echo floatval(25) + floatval(.0000000001 * gettimeofday()['usec']);
    // echo PHP_EOL;
}