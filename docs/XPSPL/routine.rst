.. /routine.php generated using docpx v1.0.0 on 01/13/14 04:53pm


Class - XPSPL\\Routine
**********************

Routine

The routine class is used by the processor during the routine calculation for
storing the idle functions and the signals which should be triggered in the
next loop.

This was added due to the current loop not providing a simple means for
objects inside the loop determining what has happened within the routine
calculation and the functionality required for the upgraded idle required
more complex algorithms which would not fit well inside the entire routine
loop method.

Methods
-------

get_signals
+++++++++++

.. function:: get_signals()


    Returns the signals to trigger in the loop.

    :rtype: array 



get_idle
++++++++

.. function:: get_idle()


    Returns the object to idle the processor.
    
    This will only return a single object which has the greatest priority.

    :rtype: integer 



get_idles_available
+++++++++++++++++++

.. function:: get_idles_available()


    Returns the objects created to idle the processor.

    :rtype: integer 



add_idle
++++++++

.. function:: add_idle($routine)


    Adds a new function to idle the engine.

    :param object: Idle

    :rtype: void 



add_signal
++++++++++

.. function:: add_signal($signal)


    Adds a signal to trigger in the loop.

    :rtype: array 



reset
+++++

.. function:: reset()


    Resets the routine after the processor has used it.

    :rtype: void 



is_stale
++++++++

.. function:: is_stale()


    Returns if the routine is stale.

    :rtype: boolean 



routine
=======
PHP File @ /routine.php

.. code-block:: php

	<?php
	namespace XPSPL;
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Routine
	 * 
	 * The routine class is used by the processor during the routine calculation for
	 * storing the idle functions and the signals which should be triggered in the
	 * next loop.
	 *
	 * This was added due to the current loop not providing a simple means for
	 * objects inside the loop determining what has happened within the routine
	 * calculation and the functionality required for the upgraded idle required
	 * more complex algorithms which would not fit well inside the entire routine
	 * loop method.
	 */
	final class Routine {
	
	    /**
	     * Signals that are ready to trigger in the loop.
	     *
	     * @var  array
	     */
	    protected $_signals = [];
	
	    /**
	     * Idle objects
	     *
	     * @var  array
	     */
	    protected $_idle = [];
	
	    /**
	     * Routine is stale receiving no changes.
	     *
	     * @var  boolean
	     */
	    protected $_is_stale = true;
	
	    /**
	     * Returns the signals to trigger in the loop.
	     *
	     * @return  array
	     */
	    public function get_signals(/* ... */)
	    {
	        return $this->_signals;
	    }
	
	    /**
	     * Returns the object to idle the processor.
	     *
	     * This will only return a single object which has the greatest priority.
	     *
	     * @return  integer
	     */
	    public function get_idle(/* ... */)
	    {
	        return (isset($this->_idle[0])) ? $this->_idle[0] : null;
	    }
	
	    /**
	     * Returns the objects created to idle the processor.
	     *
	     * @return  integer
	     */
	    public function get_idles_available(/* ... */)
	    {
	        return $this->_idle;
	    }
	
	    /**
	     * Adds a new function to idle the engine.
	     *
	     * @param  object  $idle  Idle
	     *
	     * @return  void
	     */
	    public function add_idle(SIG_Routine $routine)
	    {
	        if (!$this->_is_stale) {
	            $this->_is_stale = false;
	        }
	        if (count($this->_idle) === 0) {
	            $this->_idle[] = $routine;
	            return;
	        }
	        foreach ($this->_idle as $_k => $_func) {
	            if (get_class($_func->get_idle()) === get_class($routine->get_idle())) {
	                if (!$_func->get_idle()->allow_override()) {
	                    throw new \RuntimeException(sprintf(
	                        "Idle class %s does not allow override",
	                        get_class($_func)
	                    ));
	                }
	                if ($_func->get_idle()->override($routine->get_idle())) {
	                    $this->_idle[$_k] = $routine;
	                }
	                return;
	            }
	        }
	        $this->_idle[] = $routine;
	        if (count($this->_idle) >= 2) {
	            usort($this->_idle, function($a, $b){
	                $a = $a->get_idle()->get_priority();
	                $b = $b->get_idle()->get_priority();
	                if ($a == $b) {
	                    return 0;
	                }
	                return ($a < $b) ? -1 : 1;
	            });
	        }
	    }
	
	    /**
	     * Adds a signal to trigger in the loop.
	     *
	     * @return  array
	     */
	    public function add_signal($signal)
	    {
	        if (!$this->_is_stale) {
	            $this->_is_stale = false;
	        }
	        return $this->_signals[] = $signal;
	    }
	
	    /**
	     * Resets the routine after the processor has used it.
	     *
	     * @return  void
	     */
	    public function reset()
	    {
	        $this->_signals = [];
	        $this->_idle = [];
	    }
	
	    /**
	     * Returns if the routine is stale.
	     *
	     * @return  boolean
	     */
	    public function is_stale(/* ... */)
	    {
	        return $this->_is_stale;
	    }
	}

Created on 01/13/14 04:53pm using `Docpx <http://github.com/prggmr/docpx>`_