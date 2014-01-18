.. /erase_history.php generated using docpx v1.0.0 on 01/16/14 03:57pm


Function - xp_erase_history
***************************


.. function:: xp_erase_history()


    Erases the entire signal history.

    :rtype: void 



erase_history
=============
PHP File @ /erase_history.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Erases the entire signal history.
	 *
	 * @return  void
	 */
	function xp_erase_history()
	{
	    return XPSPL::instance()->erase_history();
	}

Created on 01/16/14 03:57pm using `Docpx <http://github.com/prggmr/docpx>`_