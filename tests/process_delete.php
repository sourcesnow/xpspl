<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

unittest\test(function($test){
    $db = new \XPSPL\database\Processes();
    $p1 = new \XPSPL\Process(null);
    $p2 = high_priority(new \XPSPL\Process(null));
    $db->install($p1);
    $db->install($p2);
    var_dump($db);
    $db->delete($p1);
    var_dump($db);
    // $test->equal($process->exhaustion(), XPSPL_PROCESS_DEFAULT_EXHAUST);
    // $test->equal($process->get_priority(), XPSPL_PROCESS_DEFAULT_PRIORITY);
}, "process delete");