<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Engine Error Assertion
 *
 * Asserts the given engine error signal triggers.
 */
unittest\create_assertion(function($signal, \Closure $function){
    ob_start();
    $function = $function->bindTo($this);
    $function();
    $contents = ob_get_contents();
    ob_end_clean();
    return stripos($contents, 'Exception: '.$signal) !== false;
}, 'engine_error_signaled', 'Error %s was not signaled');

unittest\create_assertion(function($signal, \Closure $function){
    ob_start();
    $function = $function->bindTo($this);
    $function();
    $contents = ob_get_contents();
    ob_end_clean();
    return stripos($contents, 'Exception: '.$signal) === false;
}, 'engine_error_not_signaled', 'Error %s was signaled');