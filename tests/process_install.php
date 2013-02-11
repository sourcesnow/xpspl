<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

unittest\test(function($test){
    $database = new \XPSPL\database\Processes();
    for ($i=0;$i<1000;$i++) {
        $database->install(new \XPSPL\Process(function(){}));
    }
    $test->instanceof(
        $database->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY), 
        'XPSPL\database\Processes'
    );
    $test->count($database->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY), 1000);
});