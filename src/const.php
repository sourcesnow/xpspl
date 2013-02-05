<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

if (!defined('XPSPL_DEBUG')) {
    /**
     * XPSPL Debug mode
     *
     * When debug mode is turned off an exception handler is installed that 
     * automatically removes the processor traces from the stack.
     */
    define('XPSPL_DEBUG', false);
}

if (!defined('XPSPL_SIGNAL_HISTORY')) {
    /**
     * Signal History
     * 
     * Boolean option for the signal history. 
     * 
     * By default it is ``false``.
     */
    define('XPSPL_SIGNAL_HISTORY', false);
}

if (!defined('XPSPL_PURGE_EXHAUSTED')) {
    /**
     * Remove Exhausted processes
     * 
     * Boolean option to automatically remove exhausted signals from the processor.
     *
     * By default this settings is ``true``.
     */
    define('XPSPL_PURGE_EXHAUSTED', true);
}

if (!defined('XPSPL_MODULE_DIR')) {
    /**
     * Module Directory
     * 
     * Directory to look for modules.
     *
     * By default it is set to the ``module`` directory in XPSPL.
     */
    define('XPSPL_MODULE_DIR', XPSPL_PATH . '/module');
}

if (!defined('PROCESS_DEFAULT_EXHAUST')) {
    /**
     * Default process exhaustion
     *
     * Integer option defining the default exhausting of a process.
     *
     * By default it is ``1``.
     */
    define('PROCESS_DEFAULT_EXHAUST', 1);
}

if (!defined('QUEUE_DEFAULT_PRIORITY')) {
    /**
     * Process default priority
     * 
     * Integer option defining the default priority of all processes.
     *
     * By default it is ``10``.
     */
    define('PROCESS_DEFAULT_PRIORITY', 10);
}

if (!defined('XPSPL_JUDY_SUPPORT')) {
    /**
     * Judy is an optional database configuration.
     *
     * http://xpspl.prggmr.org/en/xspel/install.html#optional
     *
     * Currently this is experimental as an attempt to improve performance.
     */
    define('XPSPL_JUDY_SUPPORT', class_exists('Judy', false));
}

if (!defined('XPSPL_ANALYZE_TIME')) {
    /**
     * Judy is an array implementation.
     *
     * For more information see http://php.net/manual/en/book.judy.php
     *
     * Currently this is experimental as an attempt to improve performance.
     */
    define('XPSPL_JUDY_SUPPORT', class_exists('Judy', false));
}

// define time instructions
define('TIME_SECONDS', 1);
define('TIME_MILLISECONDS', 2);
define('TIME_MICROSECONDS', 3);