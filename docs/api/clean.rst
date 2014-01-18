.. /clean.php generated using docpx v1.0.0 on 01/16/14 03:57pm


Function - xp_clean
*******************


.. function:: xp_clean([$history = false])


    Cleans the processor removing exhausted signals and their processes from
    the processor.
    
    Optionally the history of cleanable signals can be erased from the history.

    :param boolean: Erase any history of the signals cleaned.

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
	 * Cleans the processor removing exhausted signals and their processes from
	 * the processor.
	 *
	 * Optionally the history of cleanable signals can be erased from the history.
	 *
	 * @param  boolean  $history  Erase any history of the signals cleaned.
	 *
	 * @return  void
	 */
	function xp_clean($history = false)
	{
	    return XPSPL::instance()->clean($history);
	}

Created on 01/16/14 03:57pm using `Docpx <http://github.com/prggmr/docpx>`_