.. dir_include.php generated using docpx v1.0.0 on 02/26/14 11:56am


xp_dir_include
**************


.. function:: xp_dir_include($dir, [$listen = false, [$path = false]])


    Recursively includes all .php files with the option to start a listener
    automatically after including the file.
    
    .. note::
    
       When autostarting listeners the class name is expected in PSR-0 compliant.
    
       The ``$dir`` serves as the initial namespace for class listeners.
    
       For example ``xp_dir_include('Foobar', true);`` will load all files
       contained in the Foobar directory, with a file named ``test.php`` it
       will expect a class ``Foobar\Test`` which extends the ``XPSPL\Listener``
       object.

    :param string: Directory to include.
    :param boolean: Start listeners.
    :param string: Path to ignore when starting listeners.

    :rtype: void 



dir_include
===========
PHP File @ dir_include.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Recursively includes all .php files with the option to start a listener
	 * automatically after including the file.
	 *
	 * .. note::
	 *
	 *    When autostarting listeners the class name is expected in PSR-0 compliant.
	 *
	 *    The ``$dir`` serves as the initial namespace for class listeners.
	 *
	 *    For example ``xp_dir_include('Foobar', true);`` will load all files
	 *    contained in the Foobar directory, with a file named ``test.php`` it
	 *    will expect a class ``Foobar\Test`` which extends the ``XPSPL\Listener``
	 *    object.
	 *
	 * @param  string  $dir  Directory to include.
	 * @param  boolean  $listen  Start listeners.
	 * @param  string  $path  Path to ignore when starting listeners.
	 *
	 * @return  void
	 */
	function xp_dir_include($dir, $listen = false, $path = null)
	{
	    /**
	     * This is some pretty narly code but so far the fastest I have been able
	     * to get this to run.
	     */
	    $iterator = new \RegexIterator(
	        new \RecursiveIteratorIterator(
	            new \RecursiveDirectoryIterator($dir)
	        ), '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH
	    );
	    foreach ($iterator as $_file) {
	        array_map(function($i) use ($path, $listen){
	            include $i;
	            if (!$listen) {
	                return false;
	            }
	            $process = sprintf(
	                '%s\\%s',
	                // Namespace
	                implode('\\', array_pop(explode(
	                    (WINDOWS) ? '\\' : '/',
	                    str_replace([$path, '.php'], '', $i)
	                ))),
	                ucfirst($class)
	            );
	            if (class_exists($process, false) &&
	                is_subclass_of($process, '\XPSPL\Listener')) {
	                xp_listen(new $process());
	            }
	        }, $_file);
	    }
	}

Created on 02/26/14 11:56am using `Docpx <http://github.com/prggmr/docpx>`_