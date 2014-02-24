.. /listen.php generated using docpx v1.0.0 on 02/22/14 06:39pm


xp_listen
*********


.. function:: xp_listen()


    Registers a new object listener.

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
	 * Registers a new object listener.
	 *
	 * @param  object  $listener  The event listening object
	 *
	 * @return  void
	 */
	function xp_listen($listener)
	{
	    return XPSPL::instance()->listen($listener);
	}

Created on 02/22/14 06:39pm using `Docpx <http://github.com/prggmr/docpx>`_