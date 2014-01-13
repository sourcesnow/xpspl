.. /dir_include.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - dir_include
**********************


.. function:: dir_include($dir, [$listen = false, [$path = false]])


    Performs a inclusion of the entire directory content, including 
    subdirectories, with the option to start a listener once the file has been 
    included.

    :param string: Directory to include.
    :param boolean: Start listeners.
    :param string: Path to ignore when starting listeners.

    :rtype: void 



dir_include
===========
PHP File @ /dir_include.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Performs a inclusion of the entire directory content, including 
	 * subdirectories, with the option to start a listener once the file has been 
	 * included.
	 *
	 * @param  string  $dir  Directory to include.
	 * @param  boolean  $listen  Start listeners.
	 * @param  string  $path  Path to ignore when starting listeners.
	 *
	 * @return  void
	 */
	function dir_include($dir, $listen = false, $path = null)
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
	                listen(new $process());
	            }
	        }, $_file);
	    }
	}

Last updated on 01/13/14 04:39pm