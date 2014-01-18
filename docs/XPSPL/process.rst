.. /process.php generated using docpx v1.0.0 on 01/16/14 03:57pm


Class - XPSPL\\Process
**********************

Process

A process is the callable which will execute when a signal is emitted.

Methods
-------

__construct
+++++++++++

.. function:: __construct([$callable = false, [$exhaust = 1, [$priority = 10]]])


    Constructs a new process object.

    :param mixed: A callable php variable.
    :param integer: Count to set process exhaustion.
    :param null|integer: Priority of the process.

    :rtype: void 



decrement_exhaust
+++++++++++++++++

.. function:: decrement_exhaust()


    Decrements the exhaustion counter.

    :rtype: void 



exhaustion
++++++++++

.. function:: exhaustion()


    Returns count until process becomes exhausted

    :rtype: integer 



is_exhausted
++++++++++++

.. function:: is_exhausted()


    Determines if the process has exhausted.

    :rtype: boolean 



get_priority
++++++++++++

.. function:: get_priority()


    Returns the priority of the process.

    :rtype: integer 



get_function
++++++++++++

.. function:: get_function()


    Returns the function for the process.

    :rtype: closure|array 



set_exhaust
+++++++++++

.. function:: set_exhaust($rate)


    Sets the process exhaust rate.

    :param integer: Exhaust rate

    :rtype: void 



set_priority
++++++++++++

.. function:: set_priority($priority)


    Sets the process priority.

    :param integer: Integer Priority

    :rtype: void 



__toString
++++++++++

.. function:: __toString()


    Return a string representation of this database.

    :rtype: string 



enable_threads
++++++++++++++

.. function:: enable_threads()


    Enable threads for this process.

    :param integer: Integer Priority

    :rtype: void 



threads_enabled
+++++++++++++++

.. function:: threads_enabled()


    Returns if threads are enabled for this process.

    :rtype: boolean 



process
=======
PHP File @ /process.php

.. code-block:: php

	<?php
	namespace XPSPL;
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	use \Closure,
	    \Exception,
	    \RuntimeException;
	
	/**
	 * Process
	 * 
	 * A process is the callable which will execute when a signal is emitted.
	 */
	class Process {
	
	    /**
	     * The callable that will execute.
	     */
	    protected $_callable = null;
	
	    /**
	     * Process exhaustion.
	     *
	     * @var  integer|null
	     */
	    protected $_exhaustion = null;
	
	    /**
	     * Process priority.
	     *
	     * @var  integer
	     */
	    protected $_priority = null;
	
	    /**
	     * Threads enabled for this process.
	     *
	     * @var  boolean
	     */
	    protected $_threads = false;
	
	    /**
	     * Constructs a new process object.
	     *
	     * @param  mixed  $callable  A callable php variable.
	     * @param  integer  $exhaust  Count to set process exhaustion.
	     * @param  null|integer  $priority  Priority of the process.
	     * 
	     * @return  void
	     */
	    public function __construct($callable = null, $exhaust = XPSPL_PROCESS_DEFAULT_EXHAUST, $priority = XPSPL_PROCESS_DEFAULT_PRIORITY)
	    {
	        if (null === $callable) {
	            $reflection = new \ReflectionClass($this);
	            if ($reflection->hasMethod('execute')) {
	                $callable = [$this, 'execute'];
	            }
	            unset($reflection);
	        }
	        // set exhaust rate
	        $this->set_exhaust($exhaust);
	        $this->set_priority($priority);
	        $this->_callable = $callable;
	    }
	
	    /**
	     * Decrements the exhaustion counter.
	     *
	     * @return  void
	     */
	    final public function decrement_exhaust(/* ... */)
	    {
	        if (null !== $this->_exhaustion && $this->_exhaustion >= 0) {
	            $this->_exhaustion--;
	            return;
	        }
	    }
	
	    /**
	     * Returns count until process becomes exhausted
	     *
	     * @return  integer
	     */
	    final public function exhaustion(/* ... */)
	    {
	        return $this->_exhaustion;
	    }
	
	    /**
	     * Determines if the process has exhausted.
	     *
	     * @return  boolean
	     */
	    final public function is_exhausted()
	    {
	        if (null === $this->_exhaustion) {
	            return false;
	        }
	
	        if (0 >= $this->_exhaustion) {
	            return true;
	        }
	
	        return false;
	    }
	
	    /**
	     * Returns the priority of the process.
	     *
	     * @return  integer
	     */
	    final public function get_priority(/* ... */)
	    {
	        return $this->_priority;
	    }
	
	    /**
	     * Returns the function for the process.
	     *
	     * @return  closure|array
	     */
	    final public function get_function(/* ... */)
	    {
	        return $this->_callable;
	    }
	
	    /**
	     * Sets the process exhaust rate.
	     *
	     * @param  integer  $rate  Exhaust rate
	     * 
	     * @return  void
	     */
	    final public function set_exhaust($rate)
	    {
	        # Invalid or negative exhausting sets the rate to XPSPL_PROCESS_DEFAULT_EXHAUST.
	        if (null !== $rate && (!is_int($rate) || $rate <= -1)) {
	            $this->_exhaustion = XPSPL_PROCESS_DEFAULT_EXHAUST;
	            return;
	        }
	        $this->_exhaustion = $rate;
	    }
	
	    /**
	     * Sets the process priority.
	     *
	     * @param  integer  $priority  Integer Priority
	     * 
	     * @return  void
	     */
	    final public function set_priority($priority)
	    {
	        # Invalid or negative exhausting sets the rate to XPSPL_PROCESS_DEFAULT_PRIORITY.
	        if (null !== $priority && !is_int($priority)) {
	            $this->_priority = XPSPL_PROCESS_DEFAULT_PRIORITY;
	            return;
	        }
	        $this->_priority = $priority;
	    }
	
	    /**
	     * Return a string representation of this database.
	     *
	     * @return  string
	     */
	    public function __toString(/* ... */)
	    {
	        return sprintf('CLASS(%s) - HASH(%s) - EXHAUST(%s) PRIORITY(%s)',
	            get_class($this), 
	            spl_object_hash($this),
	            (null === $this->_exhaustion) ? 'null' : $this->_exhaustion,
	            $this->_priority
	        );
	    }
	
	    /**
	     * Enable threads for this process.
	     *
	     * @param  integer  $priority  Integer Priority
	     * 
	     * @return  void
	     */
	    final public function enable_threads(/* ... */)
	    {
	        $this->_threads = true;
	        // if (!$this->_callable instanceof process\Thread) {
	        //     if (!(is_array($this->_callable) && $this->_callable[0] === $this)) {
	        //         throw new \RuntimeException(
	        //             'Threaded processes must be implemented using the `execute` method.'
	        //         );
	        //     }
	        //     $this->_callable = new process\Thread($this->_callable);
	        //     var_dump($this);
	        // }
	        return;
	    }
	
	    /**
	     * Returns if threads are enabled for this process.
	     *
	     * @return  boolean
	     */
	    public function threads_enabled(/* ... */)
	    {
	        return $this->_threads;
	    }
	}

Created on 01/16/14 03:57pm using `Docpx <http://github.com/prggmr/docpx>`_