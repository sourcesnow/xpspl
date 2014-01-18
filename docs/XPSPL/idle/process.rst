.. /idle/process.php generated using docpx v1.0.0 on 01/13/14 04:53pm


Class - XPSPL\\idle\\Process
****************************

Idles the processor using a function process.

Methods
-------

__construct
+++++++++++

.. function:: __construct($function)


    Constructs the time idle.



idle
++++

.. function:: idle($processor)


    Run the idle function.



process
=======
PHP File @ /idle/process.php

.. code-block:: php

	<?php
	namespace XPSPL\idle;
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	use \XPSPL\Processor as Processor;
	
	/**
	 * Idles the processor using a function process.
	 */
	class Process extends \XPSPL\Idle 
	{
	    /**
	     * Priority of this idle function.
	     *
	     * @var  integer
	     */
	    protected $_priority = 1;
	
	    /**
	     * Function to run for the idle.
	     *
	     * @var  boolean
	     */
	    protected $_function = null;
	    
	
	    /**
	     * Constructs the time idle.
	     */
	    public function __construct($function)
	    {
	        if (!is_callable($function)) {
	            throw new \InvalidArgumentException(
	                "Invalid idle function"
	            );
	        }
	        $this->_function = $function;
	    }
	
	    /**
	     * Run the idle function.
	     */
	    public function idle(Processor $processor) 
	    {
	        return call_user_func_array($this->_function, [$processor]);
	    }
	}
	

Created on 01/13/14 04:53pm using `Docpx <http://github.com/prggmr/docpx>`_