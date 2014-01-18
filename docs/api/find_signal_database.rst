.. /find_signal_database.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - find_signal_database
*******************************


.. function:: find_signal_database($signal)


    Finds an installed signals processes database.

    :param object: SIG

    :rtype: null|object \XPSPL\database\Signals



find_signal_database
====================
PHP File @ /find_signal_database.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Finds an installed signals processes database.
	 *
	 * @param  object  $signal  SIG
	 * 
	 * @return  null|object  \XPSPL\database\Signals
	 */
	function find_signal_database($signal)
	{
	    if (!$signal instanceof \XPSPL\SIG) {
	        $signal = new \XPSPL\SIG();
	    }
	    return XPSPL::instance()->find_signal_database($signal);
	}

Last updated on 01/13/14 04:39pm