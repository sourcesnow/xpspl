.. /state.php generated using docpx v1.0.0 on 01/16/14 03:57pm


Trait - XPSPL\\State
********************

State

Methods
-------

__construct
+++++++++++

.. function:: __construct()


    Constructs a new state object.

    :rtype: void 



get_state
+++++++++

.. function:: get_state()


    Returns the current event state.

    :rtype: integer Current state of this event.



set_state
+++++++++

.. function:: set_state()


    Set the object state.

    :param int: State of the object.

    :throws InvalidArgumentException: 

    :rtype: void 



state
=====
PHP File @ /state.php

.. code-block:: php

	<?php
	namespace XPSPL;
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * State
	 *
	 * @since 0.3.0
	 *
	 * State is as it implies, state of a given object.
	 */ 
	trait State
	{
	    /**
	     * Current state of the object.
	     *
	     * @var  int
	     */
	    protected $_state = null;
	
	    /**
	     * Constructs a new state object.
	     * 
	     * @return  void
	     */
	    public function __construct() 
	    {
	        $this->_state = STATE_DECLARED;
	    }
	
	    /**
	     * Returns the current event state.
	     *
	     * @return  integer  Current state of this event.
	     */
	    final public function get_state(/* ... */)
	    {
	        return $this->_state;
	    }
	
	    /**
	     * Set the object state.
	     *
	     * @param  int  $state  State of the object.
	     *
	     * @throws  InvalidArgumentException
	     *
	     * @return  void
	     */
	    final public function set_state($state) 
	    {
	        $this->_state = $state;
	    }
	}
	

Created on 01/16/14 03:57pm using `Docpx <http://github.com/prggmr/docpx>`_