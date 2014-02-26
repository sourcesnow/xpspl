.. process.php generated using docpx v1.0.0 on 02/26/14 11:56am


xp_process
**********


.. function:: xp_process($callable)


    Generates a \XPSPL\Process object from the given PHP callable.
    
    .. note::
    
       See the ``priority`` and ``exhaust`` functions for setting the priority
       and exhaust of the created process.

    :param callable: 

    :rtype: void 


Creates a new XPSPL Process object.
###################################

.. code-block::php

   <?php

   $process = xp_process(function(){});

   xp_signal(XP_SIG('foo'), $process);



process
=======
PHP File @ process.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Generates a \XPSPL\Process object from the given PHP callable.
	 *
	 * .. note::
	 *
	 *    See the ``priority`` and ``exhaust`` functions for setting the priority
	 *    and exhaust of the created process.
	 *
	 * @param  callable  $callable
	 *
	 * @return  void
	 *
	 * @example
	 *
	 * Creates a new XPSPL Process object.
	 *
	 * .. code-block::php
	 *
	 *    <?php
	 *
	 *    $process = xp_process(function(){});
	 *
	 *    xp_signal(XP_SIG('foo'), $process);
	 *
	 */
	function xp_process($callable)
	{
	    return new \XPSPL\Process($callable);
	}

Created on 02/26/14 11:56am using `Docpx <http://github.com/prggmr/docpx>`_