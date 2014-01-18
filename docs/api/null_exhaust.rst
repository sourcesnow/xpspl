.. /null_exhaust.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - null_exhaust
***********************


.. function:: null_exhaust($process)


    Registers the given process to have a null exhaust.
    
    Be careful when registering a null exhaust process.
    
    Once registered it will **never** be purged from the processor.
    
    **Do not** register a null exhaust process unless you are absolutely sure you  
    want it to never exhaust.
    
    If you require a process to exhaust after a few executions use the ``rated_exhaust`` 
    function.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Install a null exhaust process.
###############################

This example installs a null exhaust process which calls an awake signal 
every 10 seconds creating an interval.

.. code-block:: php

   <?php
   import('time');
   
   time\awake(10, null_exhaust(function(){
       echo "10 seconds";
   }));



null_exhaust
============
PHP File @ /null_exhaust.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Registers the given process to have a null exhaust.
	 *
	 * Be careful when registering a null exhaust process.
	 *
	 * Once registered it will **never** be purged from the processor.
	 *
	 * **Do not** register a null exhaust process unless you are absolutely sure you  
	 * want it to never exhaust.
	 *
	 * If you require a process to exhaust after a few executions use the ``rated_exhaust`` 
	 * function.
	 *
	 * @param  callable|process  $process  PHP Callable or Process.
	 *
	 * @return  object  Process
	 *
	 * @example
	 *
	 * Install a null exhaust process.
	 *
	 * This example installs a null exhaust process which calls an awake signal 
	 * every 10 seconds creating an interval.
	 * 
	 * .. code-block:: php
	 *
	 *    <?php
	 *    import('time');
	 *    
	 *    time\awake(10, null_exhaust(function(){
	 *        echo "10 seconds";
	 *    }));
	 */ 
	function null_exhaust($process)
	{
	    if (!$process instanceof \XPSPL\Process) {
	        $process = new \XPSPL\Process($process, null);
	        return $process;
	    }
	    $process->set_exhaust(null);
	    return $process;
	}

Last updated on 01/13/14 04:39pm