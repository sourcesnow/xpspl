<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Constants file
 */


if (!defined('XPSPL_DEBUG')) {
    /**
     * XPSPL Debug mode
     */
    define('XPSPL_DEBUG', false);
}

// have the processor throw exceptions on signal errors
if (!defined('XPSPL_ENGINE_EXCEPTIONS')) {
    define('XPSPL_ENGINE_EXCEPTIONS', true);
}

// signal history original setting
if (!defined('XPSPL_SIGNAL_HISTORY')) {
    define('XPSPL_SIGNAL_HISTORY', false);
}

// immediatly removes an exhausted process from the processor
if (!defined('XPSPL_PURGE_EXHAUSTED')) {
    define('XPSPL_PURGE_EXHAUSTED', true);
}

// modules directory
if (!defined('XPSPL_MODULE_DIR')) {
    define('XPSPL_MODULE_DIR', XPSPL_PATH . '/module');
}

// detect if using windows ...
if (!defined('WINDOWS')) {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        define('WINDOWS', true);
    } else {
        define('WINDOWS', false);
    }
}

// define time instructions
define('TIME_SECONDS', 1);
define('TIME_MILLISECONDS', 2);

// Default process exhaustion rate.
if (!defined('PROCESS_DEFAULT_EXHAUST')) {
    define('PROCESS_DEFAULT_EXHAUST', 1);
}
