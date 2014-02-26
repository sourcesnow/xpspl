.. emit.php generated using docpx v1.0.0 on 02/26/14 11:56am


xp_emit
*******


.. function:: xp_emit($signal, [$context = false])


    Emits a signal.
    
    This will execute all processes and interruptions installed to the signal.
    
    The executed ``SIG`` object is returned.
    
    .. note::
    
       When emitting unique signals, e.g.. complex, routines or defined uniques
       the unique sig object installed must be given.
    
    Once a signal is emitted the following execution chain takes place.
    
    1. Before process interruptions
    2. Installed processes
    3. After process interruptions

    :param signal: Signal to emit.
    :param object: Signal context.

    :rtype: object SIG


Emitting a unique signal
########################

When a unique signal is emitted

.. code-block:: php

   <?php
   // Create a unique Foo signal.
   class Foo extends \XPSPL\SIG {
       // declare it as unique
       protected $_unique = true;
   }
   // Install a null exhaust process for the Foo signal
   $foo = new Foo();
   signal($foo, xp_null_exhaust(function(){
       echo "Foo";
   }));
   // Emit foo and new Foo
   xp_emit($foo);
   xp_emit(new Foo());
   // Results
   // Foo



emit
====
PHP File @ emit.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Emits a signal.
	 *
	 * This will execute all processes and interruptions installed to the signal.
	 *
	 * The executed ``SIG`` object is returned.
	 *
	 * .. note::
	 *
	 *    When emitting unique signals, e.g.. complex, routines or defined uniques
	 *    the unique sig object installed must be given.
	 *
	 * Once a signal is emitted the following execution chain takes place.
	 *
	 * 1. Before process interruptions
	 * 2. Installed processes
	 * 3. After process interruptions
	 *
	 * @param  signal  $signal  Signal to emit.
	 * @param  object  $context  Signal context.
	 *
	 * @return  object  SIG
	 *
	 * @example
	 *
	 * Emitting a unique signal
	 *
	 * When a unique signal is emitted
	 *
	 * .. code-block:: php
	 *
	 *    <?php
	 *    // Create a unique Foo signal.
	 *    class Foo extends \XPSPL\SIG {
	 *        // declare it as unique
	 *        protected $_unique = true;
	 *    }
	 *    // Install a null exhaust process for the Foo signal
	 *    $foo = new Foo();
	 *    signal($foo, xp_null_exhaust(function(){
	 *        echo "Foo";
	 *    }));
	 *    // Emit foo and new Foo
	 *    xp_emit($foo);
	 *    xp_emit(new Foo());
	 *    // Results
	 *    // Foo
	 */
	function xp_emit($signal, $context = null)
	{
	    if (!$signal instanceof \XPSPL\SIG) {
	        $signal = new \XPSPL\SIG($signal);
	    }
	    return XPSPL::instance()->emit($signal, $context);
	}

Created on 02/26/14 11:56am using `Docpx <http://github.com/prggmr/docpx>`_