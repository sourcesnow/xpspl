.. /threaded_process.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - threaded_process
***************************


.. function:: threaded_process($process)


    Enables a process to execute within it's own thread.
    
    This works only when the PECL package pthreads is installed.
    
    .. warning::
    
       Threaded functionality within XPSPL is still *highly* experiemental...
    
       Use this at your own RISK!.


Executing processes in their own thread.
########################################

.. code-block:: php

   <?php

   signal(SIG('foo'), threaded_process(function($sig){
       print 'Executed in own thread';
       sleep(10);
   });

    :param callable: PHP Callable

    :rtype: void 



threaded_process
================
PHP File @ /threaded_process.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Enables a process to execute within it's own thread.
	 *
	 * This works only when the PECL package pthreads is installed.
	 *
	 * .. warning::
	 *
	 *    Threaded functionality within XPSPL is still *highly* experiemental...
	 *
	 *    Use this at your own RISK!.
	 *
	 * @example
	 *
	 * Executing processes in their own thread.
	 *
	 * .. code-block:: php
	 *
	 *    <?php
	 *
	 *    signal(SIG('foo'), threaded_process(function($sig){
	 *        print 'Executed in own thread';
	 *        sleep(10);
	 *    });
	 *
	 * @param  callable  $process  PHP Callable
	 *
	 * @return  void
	 */
	function threaded_process($process)
	{
		if (!$process instanceof \XPSPL\Process) {
	        $process = new \XPSPL\Process($process);
	    }
	    $process->enable_threads();
	    return $process;
	}

Last updated on 01/13/14 04:39pm