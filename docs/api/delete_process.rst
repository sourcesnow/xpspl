.. /delete_process.php generated using docpx v1.0.0 on 02/22/14 06:39pm


xp_delete_process
*****************


.. function:: xp_delete_process()


    Removes an installed signal process.

    :param string|integer|object: Signal process is attached to.
    :param object: Process.

    :rtype: void 


Delete installed process
########################

Removes the installed process from the foo signal.

.. code-block::php

   <?php
   $process = xp_signal(XP_SIG('foo'), function(){});

   xp_delete_process(XP_SIG('foo'), $process);



delete_process
==============
PHP File @ /delete_process.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Removes an installed signal process.
	 *
	 * @param  string|integer|object  $signal  Signal process is attached to.
	 * @param  object  $process  Process.
	 *
	 * @return  void
	 *
	 * @example
	 *
	 * Delete installed process
	 *
	 * Removes the installed process from the foo signal.
	 *
	 * .. code-block::php
	 *
	 *    <?php
	 *    $process = xp_signal(XP_SIG('foo'), function(){});
	 *
	 *    xp_delete_process(XP_SIG('foo'), $process);
	 */
	function xp_delete_process($signal, $process)
	{
	    return XPSPL::instance()->delete_process($signal, $process);
	}

Created on 02/22/14 06:39pm using `Docpx <http://github.com/prggmr/docpx>`_