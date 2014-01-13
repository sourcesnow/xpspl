.. /singleton.php generated using Docpx v1.0.0 on 01/13/14 04:48pm


Trait - XPSPL\\Singleton
************************

Singleton trait used for making a singleton object.

Methods
-------

instance
++++++++

.. function:: instance()


    Returns an instance of the singleton.
    
    Passes args to constructor



__clone
+++++++

.. function:: __clone()


    Disallow cloning



singleton
=========
PHP File @ /singleton.php

.. code-block:: php

	<?php
	namespace XPSPL;
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Singleton trait used for making a singleton object.
	 */
	trait Singleton {
	
	    /**
	     * @var  object|null  Instanceof the singleton
	     */
	    private static $_instance = null;
	
	    /**
	     * Returns an instance of the singleton.
	     * 
	     * Passes args to constructor
	     */
	    final public static function instance(/* ... */)
	    {
	        if (null === static::$_instance) {
	            static::$_instance = new self(func_get_args());
	        }
	
	        return self::$_instance;
	    }
	
	    /**
	     * Disallow cloning
	     */
	    final public function __clone() {
	        return false;
	    }
	}

Last updated on 01/13/14 04:48pm