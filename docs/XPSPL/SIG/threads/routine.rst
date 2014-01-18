.. /SIG/threads/routine.php generated using docpx v1.0.0 on 01/13/14 04:53pm


Class - XPSPL\\SIG\\threads\\Routine
************************************

Idles the processor checking if registered processor threads are alive.

Threaded extends and replaces the Time idle in the processor once threaded 
processes are registered.

Methods
-------

__construct
+++++++++++

.. function:: __construct()



routine
+++++++

.. function:: routine($routine)


    Run the idle function.



routine
=======
PHP File @ /SIG/threads/routine.php

.. code-block:: php

	<?php
	namespace XPSPL\SIG\threads;
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Idles the processor checking if registered processor threads are alive.
	 *
	 * Threaded extends and replaces the Time idle in the processor once threaded 
	 * processes are registered.
	 */
	class Routine extends \XPSPL\SIG_Routine
	{   
	
	    public function __construct()
	    {
	        $this->_idle = new \XPSPL\idle\Threads(0, TIME_SECONDS);
	    }
	
	    /**
	     * Run the idle function.
	     */
	    public function routine(\XPSPL\Routine $routine) 
	    {
	        // TODO - Add function to fetch lowest idle time
	        $routine->add_idle($this);
	    }
	}
	

Created on 01/13/14 04:53pm using `Docpx <http://github.com/prggmr/docpx>`_