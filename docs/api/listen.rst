.. /listen.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - listen
*****************


.. function:: listen($listener)


    Registers a new event listener object in the processor.

    :param object: The event listening object

    :rtype: void 



listen
======
PHP File @ /listen.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Registers a new event listener object in the processor.
	 * 
	 * @param  object  $listener  The event listening object
	 * 
	 * @return  void
	 */
	function listen($listener)
	{
	    return XPSPL::instance()->listen($listener);
	}

Last updated on 01/13/14 04:39pm