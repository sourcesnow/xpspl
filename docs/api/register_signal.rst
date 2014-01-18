.. /register_signal.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - register_signal
**************************


.. function:: register_signal($signal)


    Registers a signal in the processor.

    :param string|integer|object: Signal

    :rtype: object Database



register_signal
===============
PHP File @ /register_signal.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Registers a signal in the processor.
	 * 
	 * @param  string|integer|object  $signal  Signal
	 *
	 * @return  object  Database
	 */
	function register_signal($signal)
	{
	    return XPSPL::instance()->register_signal($signal);
	}

Last updated on 01/13/14 04:39pm