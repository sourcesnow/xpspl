<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

xp_import('unittest');

date_default_timezone_set('America/New_York');

ini_set('memory_limit', -1);

if (!function_exists('xdebug_start_code_coverage')) {
    \unittest\Output::send(
        'Coverage skipped xdebug not installed',
        \unittest\Output::ERROR,
        true
    );
} else {
    xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
    //xdebug_start_code_coverage();

    xp_on_shutdown(function(){
        $exclude = [
            'api.php', 'XPSPL.php', '__init__.php',
            'examples', 'tests', 'module'
        ];
        $coverage = xdebug_get_code_coverage();
        xdebug_stop_code_coverage();
        $dir = new \RegexIterator(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(XPSPL_PATH)
            ), '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH
        );
        $c = [];
        $avg = [];
        foreach ($coverage as $_k => $_v) {
            $c[strtolower($_k)] = $_v;
        }
        $coverage = $c;
        unset($c);
        foreach ($dir as $_file) {
            array_map(function($i) use ($coverage, &$avg, $exclude){
                $include = true;
                $file = strtolower($i);//trim(str_replace(XPSPL_PATH, '', $i));
                foreach ($exclude as $_exclude) {
                    if (stripos($file, $_exclude) !== false) {
                        return;
                    }
                }
                if (isset($coverage[$file])) {
                    $lines = 0;
                    $total = 0;
                    foreach ($coverage[$file] as $_v) {
                        if ($_v != -2) $lines++;
                        if ($_v >= 1) {
                            $total++;
                        }
                    }
                    $avg[$file] = round(($total / $lines) * 100, 2);
                } else {
                    $avg[$file] = 0;
                }
            }, $_file);
        }
        $total = 0.00;
        foreach ($avg as $_c) {
            $total += $_c;
        }
        \unittest\Output::send(
            '--------------------',
            \unittest\Output::DEBUG,
            true
        );
        \unittest\Output::send(sprintf(
            'Total Test Coverage : %s%%',
            // $total
            round(($total / (count($avg) * 100)) * 100, 2)
        ), \unittest\Output::DEBUG, true);
        \unittest\Output::send(
            '--------------------',
            \unittest\Output::DEBUG,
            true
        );
        foreach ($avg as $_k => $_c) {
            \unittest\Output::send(sprintf(
                'File : %s',
                $_k
            ), \unittest\Output::DEBUG, true);
            \unittest\Output::send(sprintf(
                'Coverage : %s%%',
                $_c
            ), \unittest\Output::DEBUG, true);
            \unittest\Output::send(
                '--------------------',
                \unittest\Output::DEBUG,
                true
            );
        }
    });
}

xp_import("unittest");

// load the standard unittest output
unittest\generate_output();

// make sure we save the event history
xp_set_signal_history(true);