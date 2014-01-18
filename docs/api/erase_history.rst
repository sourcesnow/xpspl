.. /erase_history.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - erase_history
************************


.. function:: erase_history()


    Cleans out the entire signal history.

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
	 * Cleans out the entire signal history.
	 *
	 * @return  void
	 */
	function erase_history()
	{
	    return XPSPL::instance()->erase_history();
	}

Last updated on 01/13/14 04:39pm