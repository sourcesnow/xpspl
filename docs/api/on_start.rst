.. /on_start.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - on_start
*******************


.. function:: on_start($function)


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
	function on_start($function)
	{
	    return signal(new \XPSPL\processor\SIG_Startup(), $function);
	}

Last updated on 01/13/14 04:39pm