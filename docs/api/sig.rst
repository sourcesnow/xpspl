.. /sig.php generated using docpx v1.0.0 on 01/16/14 03:57pm


Function - XP_SIG
*****************


.. function:: XP_SIG($signal)


    Generates an XPSPL SIG object from the given ``$signal``.
    
    This function is only a shorthand for ``new SIG($signal)``.

    :param string|: Signal process is attached to.

    :rtype: object \XPSPL\SIG


Creating a SIG.
###############

This will create a SIG idenitified by 'foo'.

.. code-block:: php

   <?php
   xp_signal(XP_SIG('foo'), function(){
       echo "HelloWorld";
   });

   emit(XP_SIG('foo'));



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
	 *    xp_signal(XP_SIG('foo'), function(){
	 *        echo "HelloWorld";
	 *    });
	 *
	 *    emit(XP_SIG('foo'));
	 */
	function XP_SIG($signal)
	{
	    return new \XPSPL\SIG($signal);
	}

Created on 01/16/14 03:57pm using `Docpx <http://github.com/prggmr/docpx>`_