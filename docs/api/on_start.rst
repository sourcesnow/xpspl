.. /on_start.php generated using docpx v1.0.0 on 02/22/14 06:39pm


xp_on_start
***********


.. function:: xp_on_start()


    Call the provided function on processor start.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process



on_start
========
PHP File @ /on_start.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Call the provided function on processor start.
	 *
	 * @param  callable|object  $function  Function or process object
	 *
	 * @return  object  \XPSPL\Process
	 */
	function xp_on_start($function)
	{
	    return xp_signal(new \XPSPL\processor\SIG_Startup(), $function);
	}

Created on 02/22/14 06:39pm using `Docpx <http://github.com/prggmr/docpx>`_