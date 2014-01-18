.. /current_signal.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - current_signal
*************************


.. function:: current_signal([$offset = false])


    Returns the current signal in execution.

    :param integer: In memory hierarchy offset +/-.

    :rtype: object 



current_signal
==============
PHP File @ /current_signal.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Returns the current signal in execution.
	 *
	 * @param  integer  $offset  In memory hierarchy offset +/-.
	 *
	 * @return  object
	 */
	function current_signal($offset = 0)
	{
	    return XPSPL::instance()->current_signal($offset);
	}

Last updated on 01/13/14 04:39pm