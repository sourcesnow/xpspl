.. shutdown.php generated using docpx v1.0.0 on 02/26/14 11:56am


xp_shutdown
***********


.. function:: xp_shutdown()


    Sends the loop the shutdown signal.

    :rtype: void 



shutdown
========
PHP File @ shutdown.php

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
	function xp_shutdown()
	{
	    return XPSPL::instance()->shutdown();
	}

Created on 02/26/14 11:56am using `Docpx <http://github.com/prggmr/docpx>`_