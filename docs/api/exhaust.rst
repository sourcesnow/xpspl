.. /exhaust.php generated using docpx v1.0.0 on 01/16/14 03:57pm


Function - xp_exhaust
*********************


.. function:: xp_exhaust($limit, $process)


    Defines the number of times a process will execute when a signal is emitted.
    
    If you require a null exhaust process use the ``xp_null_exhaust`` function.
    
    .. note::
    
        By default all processes have an exhaust rate of 1.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Exhaust usage
#############

Defines the given process with an exhaust of 5.

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), xp_exhaust(5, function(){
       echo 'foo';
   });

   for($i=0;$i<5;$i++){
       xp_emit('foo');
   }

   // results
   // foofoofoofoofoo



exhaust
=======
PHP File @ /exhaust.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Defines the number of times a process will execute when a signal is emitted.
	 *
	 * If you require a null exhaust process use the ``xp_null_exhaust`` function.
	 *
	 * .. note::
	 *
	 *     By default all processes have an exhaust rate of 1.
	 *
	 * @param  callable|process  $process  PHP Callable or Process.
	 *
	 * @return  object  Process
	 *
	 * @example
	 *
	 * Exhaust usage
	 *
	 * Defines the given process with an exhaust of 5.
	 *
	 * .. code-block:: php
	 *
	 *    <?php
	 *
	 *    xp_signal(XP_SIG('foo'), xp_exhaust(5, function(){
	 *        echo 'foo';
	 *    });
	 *
	 *    for($i=0;$i<5;$i++){
	 *        xp_emit('foo');
	 *    }
	 *
	 *    // results
	 *    // foofoofoofoofoo
	 */
	function xp_exhaust($limit, $process)
	{
	    if (!$process instanceof \XPSPL\Process) {
	        $process = new \XPSPL\Process($process, $limit);
	        return $process;
	    }
	    $process->set_exhaust($limit);
	    return $process;
	}

Created on 01/16/14 03:57pm using `Docpx <http://github.com/prggmr/docpx>`_