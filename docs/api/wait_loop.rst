.. /wait_loop.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - wait_loop
********************


.. function:: wait_loop()


    Starts the XPSPL wait loop.

    :rtype: void 



wait_loop
=========
PHP File @ /wait_loop.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Starts the XPSPL wait loop.
	 *
	 * @return  void
	 */
	function wait_loop()
	{
	    return XPSPL::instance()->wait_loop();
	}

Last updated on 01/13/14 04:39pm