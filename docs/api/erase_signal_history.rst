.. /erase_signal_history.php generated using docpx v1.0.0 on 01/16/14 03:57pm


Function - xp_erase_signal_history
**********************************


.. function:: xp_erase_signal_history($signal)


    Erases any history of a signal.

    :param string|object: Signal to be erased from history.

    :rtype: void 



erase_signal_history
====================
PHP File @ /erase_signal_history.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Erases any history of a signal.
	 *
	 * @param  string|object  $signal  Signal to be erased from history.
	 *
	 * @return  void
	 */
	function xp_erase_signal_history($signal)
	{
	    return XPSPL::instance()->erase_signal_history($signal);
	}

Created on 01/16/14 03:57pm using `Docpx <http://github.com/prggmr/docpx>`_