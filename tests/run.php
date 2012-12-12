<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

prggmr\load_module("unittest");

// load the standard unittest output
prggmr\generate_unittest_output();

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
if (function_exists('xdebug_start_code_coverage')) {
    // prggmr\handle(new prggmr\engine\signal\Loop_Start(), function(){
    //     xdebug_start_code_coverage();
    // });
    // prggmr\handle(new prggmr\engine\signal\Loop_Shutdown(), function(){
    //     $coverage = xdebug_get_code_coverage();
    //     foreach ($coverage as $_file => $_line) {
    //         $_data = file_get_contents($_file);
    //         var_dump(token_get_all($_data));
    //         exit;
    //     }
    // });
}

