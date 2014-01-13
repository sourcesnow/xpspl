.. /delete_signal.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - delete_signal
************************


.. function:: delete_signal($signal, [$history = false])


    Delete a signal from the processor.

    :param string|object|int: Signal to delete.
    :param boolean: Erase any history of the signal.

    :rtype: boolean 



delete_signal
=============
PHP File @ /delete_signal.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Delete a signal from the processor.
	 * 
	 * @param  string|object|int  $signal  Signal to delete.
	 * @param  boolean  $history  Erase any history of the signal.
	 * 
	 * @return  boolean
	 */
	function delete_signal($signal, $history = false)
	{
	    return XPSPL::instance()->delete_signal($signal, $history);
	}

Last updated on 01/13/14 04:39pm