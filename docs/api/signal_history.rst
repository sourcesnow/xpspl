.. /signal_history.php generated using docpx v1.0.0 on 02/22/14 06:39pm


xp_signal_history
*****************


.. function:: xp_signal_history()


    Returns the current signal history.
    
    The returned history is stored in an array using the following indexes.
    
    .. code-block:: php
    
       <?php
       $array = [
           0 => Signal Object
           1 => Time in microseconds since Epoch at emittion
       ];

    :rtype: array 


Counting emitted signals
########################

This counts the number of ``XP_SIG('foo')`` signals that were emitted.

.. code-block:: php

   <?php
   $sig = XP_SIG('foo');
   // Emit a few foo objects
   for($i=0;$i<5;$i++){
       xp_emit($sig);
   }
   $emitted = 0;
   foreach(xp_signal_history() as $_node) {
       if ($_node[0] instanceof $sig) {
           $emitted++;
       }
   }
   echo $emitted;



signal_history
==============
PHP File @ /signal_history.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Returns the current signal history.
	 *
	 * The returned history is stored in an array using the following indexes.
	 *
	 * .. code-block:: php
	 *
	 *    <?php
	 *    $array = [
	 *        0 => Signal Object
	 *        1 => Time in microseconds since Epoch at emittion
	 *    ];
	 *
	 * @return  array
	 *
	 * @example
	 *
	 * Counting emitted signals
	 *
	 * This counts the number of ``XP_SIG('foo')`` signals that were emitted.
	 *
	 * .. code-block:: php
	 *
	 *    <?php
	 *    $sig = XP_SIG('foo');
	 *    // Emit a few foo objects
	 *    for($i=0;$i<5;$i++){
	 *        xp_emit($sig);
	 *    }
	 *    $emitted = 0;
	 *    foreach(xp_signal_history() as $_node) {
	 *        if ($_node[0] instanceof $sig) {
	 *            $emitted++;
	 *        }
	 *    }
	 *    echo $emitted;
	 */
	function xp_signal_history(/* ... */)
	{
	    return XPSPL::instance()->signal_history();
	}

Created on 02/22/14 06:39pm using `Docpx <http://github.com/prggmr/docpx>`_