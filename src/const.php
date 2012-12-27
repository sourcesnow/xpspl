<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Constants file
 */

// debugging mode disabled by default
if (!defined('XPSPL_DEBUG')) {
    define('XPSPL_DEBUG', false);
}

// have the engine throw exceptions on signal errors
if (!defined('XPSPL_ENGINE_EXCEPTIONS')) {
    define('XPSPL_ENGINE_EXCEPTIONS', true);
}

// signal history original setting
if (!defined('XPSPL_SIGNAL_HISTORY')) {
    define('XPSPL_SIGNAL_HISTORY', false);
}

// signal exceptions not throw
if (!defined('XPSPL_SIGNAL_EXCEPTIONS')) {
    define('XPSPL_SIGNAL_EXCEPTIONS', false);
}

// immediatly removes exhausted handles from the engine
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

// Default handle exhaustion rate.
if (!defined('EXHAUST_DEFAULT')) {
    define('EXHAUST_DEFAULT', 1);
}
