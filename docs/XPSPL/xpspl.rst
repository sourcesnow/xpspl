.. /xpspl.php generated using Docpx v1.0.0 on 01/13/14 04:48pm


Class - XPSPL
*************

The XPSPL object works as the global instance used for managing the
global processor instance.

Methods
-------

init
++++

.. function:: init()


    Initialise the global processor instance.

    :param boolean: Store a history of all events.

    :rtype: object XPSPL\Processor



version
+++++++

.. function:: version()


    Returns the current version of XPSPL.

    :rtype: string 



Constants
---------

- XPSPL_VERSION
Copyright 2010-12 Nickolas Whiting. All rights reserved.
Use of this source code is governed by the Apache 2 license
that can be found in the LICENSE file.

- XPSPL_MASTERMIND
- XPSPL_PATH
xpspl
=====
PHP File @ /xpspl.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	// library version
	define('XPSPL_VERSION', '4.0.0');
	
	// The creator
	define('XPSPL_MASTERMIND', 'Nickolas C. Whiting');
	
	// Add this to include path
	if (!defined('XPSPL_PATH')) {
	    define('XPSPL_PATH', dirname(realpath(__FILE__)).'/..');
	}
	set_include_path(XPSPL_PATH . '/..' . PATH_SEPARATOR . get_include_path());
	set_include_path(XPSPL_PATH . '/module' . PATH_SEPARATOR . get_include_path());
	
	// start'er up
	// utils & traits
	require XPSPL_PATH.'/src/utils.php';
	require XPSPL_PATH.'/src/api.php';
	require XPSPL_PATH.'/src/const.php';
	
	// dev mode
	if (XPSPL_DEBUG) {
	    error_reporting(E_ALL);
	}
	
	/**
	 * The XPSPL object works as the global instance used for managing the
	 * global processor instance.
	 */
	final class XPSPL extends \XPSPL\Processor {
	
	    use XPSPL\Singleton;
	
	    /**
	     * Initialise the global processor instance.
	     *
	     * @param  boolean  $event_history  Store a history of all events.
	     * 
	     * @return  object  XPSPL\Processor
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
	 * Start the processor VROOOOOOM!
	 */
	$XPSPL = XPSPL::init(XPSPL_SIGNAL_HISTORY);

Last updated on 01/13/14 04:48pm