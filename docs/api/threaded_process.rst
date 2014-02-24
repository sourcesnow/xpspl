.. /threaded_process.php generated using docpx v1.0.0 on 02/22/14 06:39pm


xp_threaded_process
*******************


.. function:: xp_threaded_process()


    Enables a process to execute within it's own thread.
    
    This works only when the PECL package pthreads is installed.
    
    .. warning::
    
       Threaded functionality within XPSPL is still *highly* experiemental...
    
       Use this at your own RISK!.


Executing processes in their own thread.
########################################

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), threaded_process(function($sig){
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
	 *    xp_signal(XP_SIG('foo'), threaded_process(function($sig){
	 *        print 'Executed in own thread';
	 *        sleep(10);
	 *    });
	 *
	 * @param  callable  $process  PHP Callable
	 *
	 * @return  void
	 */
	function xp_threaded_process($process)
	{
		if (!$process instanceof \XPSPL\Process) {
	        $process = new \XPSPL\Process($process);
	    }
	    $process->enable_threads();
	    return $process;
	}

Created on 02/22/14 06:39pm using `Docpx <http://github.com/prggmr/docpx>`_