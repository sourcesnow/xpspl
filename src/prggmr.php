<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

// library version
define('PRGGMR_VERSION', '2.0.0-RC1');

// The creator
define('PRGGMR_MASTERMIND', 'Nickolas Whiting');

// dev mode
if (defined('PRGGMR_DEV_MODE')) {
    error_reporting(E_ALL);
}

// Add this to include path
$prggmr_path = dirname(realpath(__FILE__));
set_include_path($prggmr_path.'/../../' . PATH_SEPARATOR . get_include_path());

// start'er up
// utils & traits
require $prggmr_path.'/utils.php';
require $prggmr_path.'/api.php';

// debugging mode disabled by default
if (!defined('PRGGMR_DEBUG')) {
    define('PRGGMR_DEBUG', false);
}

// evented exceptions disabled by default
if (!defined('SIGNAL_ERRORS_EXCEPTIONS')) {
    define('SIGNAL_ERRORS_EXCEPTIONS', false);
}
/**
 * The prggmr object works as the global instance used for managing the
 * global engine instance.
 */
final class prggmr extends \prggmr\Engine {

    use prggmr\Singleton;

    /**
     * Initialise the global engine instance.
     *
     * @param  boolean  $event_history  Store a history of all events.
     * @param  boolean  $engine_exceptions  Throw an exception when a error 
     *                                      signal is triggered.
     * 
     * @return  object  prggmr\Engine
     */
    final public static function init($event_history = true, $engine_exceptions = true) 
    {
        if (null === static::$_instance) {
            static::$_instance = new self($event_history, $engine_exceptions);
        }
        return static::$_instance;
    }

    /**
     * Returns the current version of prggmr.
     *
     * @return  string
     */
    final public static function version(/* ... */)
    {
        return PRGGMR_VERSION;
    }
}

/**
 * Enables prggmr to transform any errors and exceptions into a 
 * catchable signal.
 */
if (SIGNAL_ERRORS_EXCEPTIONS === true) {
    set_error_handler("signal_exceptions");
    set_exception_handler("signal_errors");
}
