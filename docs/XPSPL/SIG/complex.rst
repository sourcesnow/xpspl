.. /SIG/complex.php generated using Docpx v1.0.0 on 01/13/14 04:48pm


Class - XPSPL\\SIG_Complex
**************************

SIG_Complex

Methods
-------

evaluate
++++++++

.. function:: evaluate([$signal = false])


    Evaluates the emitted signal.

    :param string|integer: Signal to evaluate

    :rtype: boolean|object False|XPSPL\Evaluation



complex
=======
PHP File @ /SIG/complex.php

.. code-block:: php

	<?php
	namespace XPSPL;
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	use \LogicException,
	    \XPSPL\Routine;
	
	/**
	 * SIG_Complex
	 * 
	 * @since v0.3.0
	 * 
	 * SIG_Complex evaluates the emitting signal to provide the processor 
	 * information for.
	 *
	 * - Signals to emit
	 */
	abstract class SIG_Complex extends SIG {
	
	    protected $_unique = true;
	
	    /**
	     * Evaluates the emitted signal.
	     *
	     * @param  string|integer  $signal  Signal to evaluate
	     *
	     * @return  boolean|object  False|XPSPL\Evaluation
	     */
	    abstract public function evaluate($signal = null);
	}

Last updated on 01/13/14 04:48pm