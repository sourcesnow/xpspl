.. /xpspl_flush.php generated using docpx v1.0.0 on 02/22/14 06:39pm


XPSPL_flush
***********


.. function:: XPSPL_flush()


    Empties the storage, history and clears the current state.

    :rtype: void 



xpspl_flush
===========
PHP File @ /xpspl_flush.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Empties the storage, history and clears the current state.
	 *
	 * @return void
	 */
	function XPSPL_flush(/* ... */)
	{
	    return XPSPL::instance()->flush();
	}

Created on 02/22/14 06:39pm using `Docpx <http://github.com/prggmr/docpx>`_