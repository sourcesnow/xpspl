.. null_exhaust.php generated using docpx v1.0.0 on 02/26/14 11:56am


xp_null_exhaust
***************


.. function:: xp_null_exhaust($process)


    Nullifies a processes exhaustion rate.
    
    This allows for processes to exhaust indefiantly when a signal is emitted.
    
    .. note::
    
        Once a process is registered with a null exhaust it will **never**
        be purged from the processor.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Install a null exhaust process.
###############################

This example installs a null exhaust process which calls an awake signal
every 10 seconds creating an interval.

.. code-block:: php

   <?php
   import('time');

   time\awake(10, xp_null_exhaust(function(){
       echo "10 seconds";
   }));



null_exhaust
============
PHP File @ null_exhaust.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Nullifies a processes exhaustion rate.
	 *
	 * This allows for processes to exhaust indefiantly when a signal is emitted.
	 *
	 * .. note::
	 *
	 *     Once a process is registered with a null exhaust it will **never**
	 *     be purged from the processor.
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
	 *    time\awake(10, xp_null_exhaust(function(){
	 *        echo "10 seconds";
	 *    }));
	 */
	function xp_null_exhaust($process)
	{
	    if (!$process instanceof \XPSPL\Process) {
	        $process = new \XPSPL\Process($process, null);
	        return $process;
	    }
	    $process->set_exhaust(null);
	    return $process;
	}

Created on 02/26/14 11:56am using `Docpx <http://github.com/prggmr/docpx>`_