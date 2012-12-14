<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

prggmr\load_module("unittest");

// load the standard unittest output
prggmr\generate_unittest_output();

// make sure we save the event history
prggmr\save_event_history(true);

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
        \prggmr\unittest\Output::send(
            'Coverage skipped xdebug not installed', 
            \prggmr\unittest\Output::ERROR, 
            true
        );
    } else {

    prggmr\on_start(function(){
        xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
    });

    prggmr\on_shutdown(function(){
        $exclude = [
            '/api.php', '/prggmr.php'
        ];
        $coverage = xdebug_get_code_coverage();
        xdebug_stop_code_coverage();
        $dir = new \RegexIterator(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(PRGGMR_PATH)
            ), '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH
        );
        $avg = [];
        foreach ($dir as $_file) {
            array_map(function($i) use ($coverage, &$avg, $exclude){
                $file = trim(str_replace(PRGGMR_PATH, '', $i));
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
        \prggmr\unittest\Output::send(
            '--------------------', 
            \prggmr\unittest\Output::DEBUG, 
            true
        );
        \prggmr\unittest\Output::send(sprintf(
            'Total Test Coverage : %s%%',
            round(($total / (count($avg) * 100)) * 100, 2)
        ), \prggmr\unittest\Output::DEBUG, true);
        \prggmr\unittest\Output::send(
            '--------------------', 
            \prggmr\unittest\Output::DEBUG, 
            true
        );
        foreach ($avg as $_k => $_c) {
            \prggmr\unittest\Output::send(sprintf(
                'File : %s',
                str_replace(PRGGMR_PATH, '', $_k)
            ), \prggmr\unittest\Output::DEBUG, true);
            \prggmr\unittest\Output::send(sprintf(
                'Coverage : %s%%',
                $_c
            ), \prggmr\unittest\Output::DEBUG, true);
            \prggmr\unittest\Output::send(
                '--------------------', 
                \prggmr\unittest\Output::DEBUG, 
                true
            );
        }
    });
    
    }
}

