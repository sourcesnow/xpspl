<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Utilities
 * 
 * These are utility functions used within or in conjunction with prggmr.
 */

/**
 * Prggmr autoloader
 */
define('PRGGMR_AUTOLOADER', true);
if (!defined('PRGGMR_AUTOLOAD_STRICT')) {
    define('PRGGMR_AUTOLOAD_STRICT', true);
}
spl_autoload_register(function($class){
    // remove prggmr name from class name
    $paths = explode('\\', $class);
    $lib = array_shift($paths);
    $file = $lib.'/'.'src/'.strtolower(implode('/', $paths)).'.php';
    if (!file_exists($file) && false === PRGGMR_AUTOLOAD_STRICT) return;
    include $file;
});

/**
 * Returns the current time since epox in milliseconds.
 * 
 * @return  integer
 */
function milliseconds(/* ... */) {
    return microseconds() * 1000;
}

/**
 * Returns the current time since epox in microseonds.
 *
 * @return  integer
 */
function microseconds(/* ... */) {
    return round(microtime(true));
}

/**
 * Transforms PHP exceptions into a signal.
 * 
 * The signal fired is \prggmr\engine\Signal::GLOBAL_EXCEPTION
 * 
 * @param  object  $exception  \Exception
 * 
 * @return void
 */
function signal_exceptions($exception) {
    \prggmr\signal(\prggmr\engine\signal\Error(), $exception);
}

/**
 * Transforms PHP errors into a signal.
 * 
 * The signal fired is \prggmr\engine\Signal::GLOBAL_ERROR
 * 
 * @param  int  $errno
 * @param  string  $errstr
 * @param  string  $errfile
 * @param  int  $errline
 * 
 * @return  void
 */
function signal_errors($errno, $errstr, $errfile, $errline) {
    \prggmr\signal(new \prggmr\engine\signal\Error($errstr), array(
        $errstr, 0, $errno, $errfile, $errline
    ));
}

/**
 * Performs a binary search for the given node returning the index.
 * 
 * Logic:
 * 
 * 0 - Match
 * > 0 - Move backwards
 * < 0 - Move forwards
 * 
 * @param  mixed  $needle  Needle
 * @param  array  $haystack  Hackstack
 * @param  closure  $compare  Comparison function
 * 
 * @return  null|int  integer index location, null locate failure
 */
function bin_search($needle, $haystack, $compare = null) {
    if (null === $compare) {
        $compare = function($node, $needle) {
            if ($node < $needle) {
                return -1;
            }
            if ($node > $needle) {
                return 1;
            }
            if ($node === $needle) {
                return 0;
            }
        };
    }
    
    if (count($haystack) === 0) return null;

    $low = 0;
    $high = count($haystack) - 1;
    while ($low <= $high) {
        $mid = ($low + $high) >> 1;
        $node = $haystack[$mid];
        $cmp = $compare($node, $needle);
        switch (true) {
            # match
            case $cmp === 0:
                return $mid;
                break;
            # backwards
            case $cmp < 0:
                $low = $mid + 1;
                break;
            # forwards
            case $cmp > 0:
                $high = $mid - 1;
                break;
            # null
            default:
            case $cmp === null:
                return null;
                break;
        }
    }

    return null;
}