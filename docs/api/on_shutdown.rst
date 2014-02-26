.. on_shutdown.php generated using docpx v1.0.0 on 02/26/14 11:56am


xp_on_shutdown
**************


.. function:: xp_on_shutdown($function)


    Call the provided function on processor shutdown.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process



on_shutdown
===========
PHP File @ on_shutdown.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Call the provided function on processor shutdown.
	 *
	 * @param  callable|object  $function  Function or process object
	 *
	 * @return  object  \XPSPL\Process
	 */
	function xp_on_shutdown($function)
	{
	    return xp_signal(new \XPSPL\processor\SIG_Shutdown(), $function);
	}

Created on 02/26/14 11:56am using `Docpx <http://github.com/prggmr/docpx>`_