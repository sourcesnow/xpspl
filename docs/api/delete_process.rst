.. /delete_process.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - delete_process
*************************


.. function:: delete_process($signal, $process)


    Removes an installed signal process.

    :param string|integer|object: Signal process is attached to.
    :param object: Process.

    :rtype: void 


Removing installed processes
############################

Removes the installed process from the foo signal.

.. code-block::php

   <?php
   $process = signal('foo', function(){});
   
   delete_process('foo', $process);



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
	 * Removing installed processes
	 *
	 * Removes the installed process from the foo signal.
	 *
	 * .. code-block::php
	 *
	 *    <?php
	 *    $process = signal('foo', function(){});
	 *    
	 *    delete_process('foo', $process);
	 */
	function delete_process($signal, $process)
	{
	    return XPSPL::instance()->delete_process($signal, $process);   
	}

Last updated on 01/13/14 04:39pm