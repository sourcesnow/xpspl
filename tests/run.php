<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

load_module("unittest");

// load the standard unittest output
unittest\generate_output();

// make sure we save the event history
save_signal_history(true);

/**
 * Replace with the dir_load function
 * @var [type]
 */
$dir = new \RegexIterator(
    new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator(dirname(realpath(__FILE__)))
    ), '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH
);
foreach ($dir as $_file) {
    array_map(function($i){
        require_once $i;
    }, $_file);
}

if (defined('GENERATE_CODE_COVERAGE')) {

    if (!function_exists('xdebug_start_code_coverage')) {
        \xpspl\unittest\Output::send(
            'Coverage skipped xdebug not installed', 
            \xpspl\unittest\Output::ERROR, 
            true
        );
    } else {

    on_start(function(){
        xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
    });

    on_shutdown(function(){
        $exclude = [
            '/api.php', '/xpspl.php'
        ];
        $coverage = xdebug_get_code_coverage();
        xdebug_stop_code_coverage();
        $dir = new \RegexIterator(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(XPSPL_PATH)
            ), '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH
        );
        $avg = [];
        foreach ($dir as $_file) {
            array_map(function($i) use ($coverage, &$avg, $exclude){
                $file = trim(str_replace(XPSPL_PATH, '', $i));
                if (!in_array($file, $exclude) && isset($coverage[$i])) {
                    $lines = count($coverage[$i]);
                    $total = 0;
                    foreach ($coverage[$i] as $_v) {
                        if ($_v >= 1) {
                            $total++;
                        }
                    }
                    $avg[$file] = round(($total / $lines) * 100, 2);
                }
            }, $_file);
        }
        $total = 0.00;
        foreach ($avg as $_c) {
            $total += $_c;
        }
        \xpspl\unittest\Output::send(
            '--------------------', 
            \xpspl\unittest\Output::DEBUG, 
            true
        );
        \xpspl\unittest\Output::send(sprintf(
            'Total Test Coverage : %s%%',
            round(($total / (count($avg) * 100)) * 100, 2)
        ), \xpspl\unittest\Output::DEBUG, true);
        \xpspl\unittest\Output::send(
            '--------------------', 
            \xpspl\unittest\Output::DEBUG, 
            true
        );
        foreach ($avg as $_k => $_c) {
            \xpspl\unittest\Output::send(sprintf(
                'File : %s',
                str_replace(XPSPL_PATH, '', $_k)
            ), \xpspl\unittest\Output::DEBUG, true);
            \xpspl\unittest\Output::send(sprintf(
                'Coverage : %s%%',
                $_c
            ), \xpspl\unittest\Output::DEBUG, true);
            \xpspl\unittest\Output::send(
                '--------------------', 
                \xpspl\unittest\Output::DEBUG, 
                true
            );
        }
    });
    
    }
}

