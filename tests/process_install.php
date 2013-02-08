<?php

import('unittest');

unittest\test(function($test){
    $database = new \XPSPL\database\Processes();
    $process_1 = high_priority(function(){});
    $process_2 = high_priority(function(){});
    for ($i=0;$i<10;$i++) {
        $database->install($process_1);
    }
    // for ($i=0;$i<10;$i++) {
    //     $database->install($process_2);
    // }
    $test->instanceof($database->storage()[0], 'XPSPL\database\Processes');
    $test->count($database->storage()[XPSPL_PROCESS_DEFAULT_PRIORITY], 10);
});