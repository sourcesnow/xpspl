.. /shutdown.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - shutdown
*******************


.. function:: shutdown()


    Sends the loop the shutdown signal.

    :rtype: void 



shutdown
========
PHP File @ /shutdown.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Sends the loop the shutdown signal.
	 *
	 * @return  void
	 */
	function shutdown()
	{
	    return XPSPL::instance()->shutdown();
	}

Last updated on 01/13/14 04:39pm