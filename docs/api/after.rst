.. /after.php generated using docpx v1.0.0 on 01/16/14 03:57pm


Function - xp_after
*******************


.. function:: xp_after($signal, $process)


    Installs the given process to execute after the signal ``$signal`` is emitted.
    
    .. note::
    
       Interruptions use the same prioritizing as the Processor.

    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Install a interrupt process after foo.
######################################

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), function(){
       echo 'foo';
   });

   xp_after(XP_SIG('foo'), function(){
       echo 'after foo';
   });

   // results when foo is emitted
   // fooafter foo



after
=====
PHP File @ /after.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Installs the given process to execute after the signal ``$signal`` is emitted.
	 *
	 * .. note::
	 *
	 *    Interruptions use the same prioritizing as the Processor.
	 *
	 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
	 *
	 * @return  object  Process
	 *
	 * @example
	 *
	 * Install a interrupt process after foo.
	 *
	 * .. code-block:: php
	 *
	 *    <?php
	 *
	 *    xp_signal(XP_SIG('foo'), function(){
	 *        echo 'foo';
	 *    });
	 *
	 *    xp_after(XP_SIG('foo'), function(){
	 *        echo 'after foo';
	 *    });
	 *
	 *    // results when foo is emitted
	 *    // fooafter foo
	 */
	function xp_after($signal, $process)
	{
	    if (!$signal instanceof \XPSPL\SIG) {
	        $signal = new \XPSPL\SIG($signal);
	    }
	    if (!$process instanceof \XPSPL\Process) {
	        $process = new \XPSPL\Process($process);
	    }
	    return XPSPL::instance()->after($signal, $process);
	}

Created on 01/16/14 03:57pm using `Docpx <http://github.com/prggmr/docpx>`_