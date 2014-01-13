.. /sig.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - SIG
**************


.. function:: SIG($signal)


    Generates an XPSPL SIG object from the given ``$signal``.
    
    This function is only a shorthand for ``new SIG($signal)``.

    :param string|: Signal process is attached to.

    :rtype: object \XPSPL\SIG


Creating a SIG.
###############

This will create a SIG idenitified by 'foo'.

.. code-block:: php

   <?php
   signal(SIG('foo'), function(){
       echo "HelloWorld";
   });
   
   emit(SIG('foo'));



sig
===
PHP File @ /sig.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Generates an XPSPL SIG object from the given ``$signal``.
	 *
	 * This function is only a shorthand for ``new SIG($signal)``.
	 *
	 * @param  string|  $signal  Signal process is attached to.
	 * 
	 * @return  object  \XPSPL\SIG
	 *
	 * @example
	 *
	 * Creating a SIG.
	 *
	 * This will create a SIG idenitified by 'foo'.
	 *
	 * .. code-block:: php
	 *
	 *    <?php
	 *    signal(SIG('foo'), function(){
	 *        echo "HelloWorld";
	 *    });
	 *    
	 *    emit(SIG('foo'));
	 */
	function SIG($signal)
	{
	    return new \XPSPL\SIG($signal);
	}

Last updated on 01/13/14 04:39pm