.. /clean.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - clean
****************


.. function:: clean([$history = false])


    Cleans any exhausted signals from the processor.

    :param boolean: Also erase any history of the signals cleaned.

    :rtype: void 



clean
=====
PHP File @ /clean.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Cleans any exhausted signals from the processor.
	 * 
	 * @param  boolean  $history  Also erase any history of the signals cleaned.
	 * 
	 * @return  void
	 */
	function clean($history = false)
	{
	    return XPSPL::instance()->clean($history);
	}

Last updated on 01/13/14 04:39pm