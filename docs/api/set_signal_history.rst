.. set_signal_history.php generated using docpx v1.0.0 on 02/26/14 11:56am


xp_set_signal_history
*********************


.. function:: xp_set_signal_history($flag)


    Sets the flag for storing the event history.

    :param boolean: 

    :rtype: void 



set_signal_history
==================
PHP File @ set_signal_history.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Sets the flag for storing the event history.
	 *
	 * @param  boolean  $flag
	 *
	 * @return  void
	 */
	function xp_set_signal_history($flag)
	{
	    return XPSPL::instance()->set_signal_history($flag);
	}

Created on 02/26/14 11:56am using `Docpx <http://github.com/prggmr/docpx>`_