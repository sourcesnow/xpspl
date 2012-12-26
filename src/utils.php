<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Utilities
 * 
 * These are utility functions used within or in conjunction with xpspl.
 */

// -------------------------------------------------------------------------- \\

/**
 * Checks if runkit is installed.
 *
 * @return  void
 */
function load_runkit(/* ... */)
{
    if (!function_exists('runkit_function_redefine')) {
        defined('RUNKIT_DISALLOW',  true);
    }
}

/**
 * Prggmr autoloader
 */
define('XPSPL_AUTOLOADER', true);
spl_autoload_register(function($class){
    if (strpos($class, '\\') !== false) {
        $paths = explode('\\', $class);
        $lib = array_shift($paths);
        $file = strtolower(implode('/', $paths)).'.php';
        $src = stream_resolve_include_path($file);
        if (false !== $src) {
            include_once $src;
            return;
        }
    } else {
        $file = stream_resolve_include_path(
            strtolower($class).'.php'
        );
        if (false !== $file) {
            include_once $file;
        }
    }
});

// -------------------------------------------------------------------------- \\

/**
 * Returns the current time since epox in milliseconds.
 * 
 * @return  integer
 */
function milliseconds(/* ... */) {
    return round(microseconds() * 1000);
}

// -------------------------------------------------------------------------- \\

/**
 * Returns the current time since epox in microseonds.
 *
 * @return  integer
 */
function microseconds(/* ... */) {
    return microtime(true);
}

// -------------------------------------------------------------------------- \\

/**
 * Transforms PHP exceptions into a signal.
 * 
 * The signal fired is \xpspl\engine\Signal::GLOBAL_EXCEPTION
 * 
 * @param  object  $exception  \Exception
 * 
 * @return void
 */
function signal_exceptions($exception) {
    // \xpspl\signal(
    //     new \xpspl\engine\signal\Error(), 
    //     new \xpspl\engine\event\Error($exception)
    // );
}

// -------------------------------------------------------------------------- \\

/**
 * Transforms PHP errors into a signal.
 * 
 * The signal fired is \xpspl\engine\Signal::GLOBAL_ERROR
 * 
 * @param  int  $errno
 * @param  string  $errstr
 * @param  string  $errfile
 * @param  int  $errline
 * 
 * @return  void
 */
function signal_errors($errno, $errstr, $errfile, $errline) {
    // \xpspl\signal(
    //     new \xpspl\engine\signal\Error($errstr), 
    //     new \xpspl\engine\event\Error([
    //     $errstr, 0, $errno, $errfile, $errline
    // ]));
}

// -------------------------------------------------------------------------- \\

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
 * @return  null|integer  index, null locate failure
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

/**
 * Returns the name of a class using get_class with the namespaces stripped.
 * This will not work inside a class scope as get_class() a workaround for
 * that is using get_class_name(get_class());
 *
 * @param  object|string  $object  Object or Class Name to retrieve name
 * @return  string  Name of class with namespaces stripped
 */
function get_class_name($object = null)
{
    if (!is_object($object) && !is_string($object)) {
        return false;
    }
    
    $class = explode('\\', (is_string($object) ? $object : get_class($object)));
    return $class[count($class) - 1];
}
