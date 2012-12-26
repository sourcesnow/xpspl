<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

// library version
define('XPSPL_VERSION', '3.0.0');

// The creator
define('XPSPL_MASTERMIND', 'Nickolas Whiting');

// Add this to include path
if (!defined('XPSPL_PATH')) {
    define('XPSPL_PATH', dirname(realpath(__FILE__)).'/..');
}
set_include_path(XPSPL_PATH . '/src' . PATH_SEPARATOR . get_include_path());
set_include_path(XPSPL_PATH . '/module' . PATH_SEPARATOR . get_include_path());

// start'er up
// utils & traits
require XPSPL_PATH.'/src/utils.php';
require XPSPL_PATH.'/src/api.php';

// debugging mode disabled by default
if (!defined('XPSPL_DEBUG')) {
    define('XPSPL_DEBUG', false);
}

// have the engine throw exceptions on signal errors
if (!defined('XPSPL_ENGINE_EXCEPTIONS')) {
    define('XPSPL_ENGINE_EXCEPTIONS', true);
}

// event history original setting
if (!defined('XPSPL_EVENT_HISTORY')) {
    define('XPSPL_EVENT_HISTORY', false);
}

// dev mode
if (XPSPL_DEBUG) {
    error_reporting(E_ALL);
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

/**
 * The xpspl object works as the global instance used for managing the
 * global engine instance.
 */
final class XPSPL extends \xpspl\Engine {

    use xpspl\Singleton;

    /**
     * Initialise the global engine instance.
     *
     * @param  boolean  $event_history  Store a history of all events.
     * 
     * @return  object  xpspl\Engine
     */
    final public static function init($event_history = true) 
    {
        if (null === static::$_instance) {
            static::$_instance = new self($event_history);
        }
        return static::$_instance;
    }

    /**
     * Returns the current version of XPSPL.
     *
     * @return  string
     */
    final public static function version(/* ... */)
    {
        return XPSPL_VERSION;
    }
}

/**
 * Thats right ... that says global.
 */
global $XPSPL;

/**
 * Start the engine VROOOOOOM!
 */
$XPSPL = XPSPL::init(XPSPL_EVENT_HISTORY, XPSPL_ENGINE_EXCEPTIONS);

/**
 * Turns ANY PHP error or exception into a signal (excluding fatal)
 */
if (XPSPL_SIGNAL_EXCEPTIONS === true) {
    set_error_handler("signal_exceptions");
    set_exception_handler("signal_errors");
}

