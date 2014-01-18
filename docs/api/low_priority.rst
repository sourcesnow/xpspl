.. /low_priority.php generated using docpx v1.0.0 on 01/16/14 03:57pm


Function - xp_low_priority
**************************


.. function:: xp_low_priority($process)


    Registers the given process to have a low priority.
    
    Processes registered with a low priority will be executed after those with
    a high and default priority.
    
    .. note::
    
       This registers the priority as *PHP_INT_MAX*.
    
       This is not an interruption.
    
       After signal interrupts will still be executed after a low priority
       process.

    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Using low priority processes
############################

Low priority processes always execute last.

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), function(){
       echo 'foo';
   });

   xp_signal(XP_SIG('foo'), low_priority(function(){
       echo 'bar';
   }));

   xp_emit(XP_SIG('foo'));

   // results when foo is emitted
   // foobar



low_priority
============
PHP File @ /low_priority.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Registers the given process to have a low priority.
	 *
	 * Processes registered with a low priority will be executed after those with
	 * a high and default priority.
	 *
	 * .. note::
	 *
	 *    This registers the priority as *PHP_INT_MAX*.
	 *
	 *    This is not an interruption.
	 *
	 *    After signal interrupts will still be executed after a low priority
	 *    process.
	 *
	 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
	 *
	 * @return  object  Process
	 *
	 * @example
	 *
	 * Using low priority processes
	 *
	 * Low priority processes always execute last.
	 *
	 * .. code-block:: php
	 *
	 *    <?php
	 *
	 *    xp_signal(XP_SIG('foo'), function(){
	 *        echo 'foo';
	 *    });
	 *
	 *    xp_signal(XP_SIG('foo'), low_priority(function(){
	 *        echo 'bar';
	 *    }));
	 *
	 *    xp_emit(XP_SIG('foo'));
	 *
	 *    // results when foo is emitted
	 *    // foobar
	 */
	function xp_low_priority($process)
	{
	    return xp_priority(PHP_INT_MAX, $process);
	}

Created on 01/16/14 03:57pm using `Docpx <http://github.com/prggmr/docpx>`_