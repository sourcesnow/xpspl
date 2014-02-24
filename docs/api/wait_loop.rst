.. /wait_loop.php generated using docpx v1.0.0 on 02/22/14 06:39pm


xp_wait_loop
************


.. function:: xp_wait_loop()


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
	function xp_wait_loop()
	{
	    return XPSPL::instance()->wait_loop();
	}

Created on 02/22/14 06:39pm using `Docpx <http://github.com/prggmr/docpx>`_