.. /storage.php generated using Docpx v1.0.0 on 01/13/14 04:48pm


Class - XPSPL\\Storage
**********************

Storage.

Storage is designed to allow objects to act as a storage.

Storage provides an interface to the normal PHP functions used for
transversing an array, keeping all data within a central storage.

See the PHP Manual for more information regarding the functions used
in Storage.

Methods
-------

get_storage
+++++++++++

.. function:: get_storage()


    Returns the current storage array.

    :rtype: array 



merge
+++++

.. function:: merge($array)


    Merge an array with the current storage.

    :rtype: void 



walk
++++

.. function:: walk($func)


    Apply the given function to every node in storage.

    :param callable: 

    :rtype: void 



free
++++

.. function:: free()


    Frees the storage.



count
+++++

.. function:: count()


    Procedures.
    
    Method declares for interfaces ArrayAccess and Iterator.



current
+++++++

.. function:: current()



end
+++

.. function:: end()



key
+++

.. function:: key()



next
++++

.. function:: next()



prev
++++

.. function:: prev()



reset
+++++

.. function:: reset()



valid
+++++

.. function:: valid()



offsetExists
++++++++++++

.. function:: offsetExists($offset)



offsetSet
+++++++++

.. function:: offsetSet($offset, $value)



offsetGet
+++++++++

.. function:: offsetGet($offset)



offsetUnset
+++++++++++

.. function:: offsetUnset($offset)



rewind
++++++

.. function:: rewind()



storage
=======
PHP File @ /storage.php

.. code-block:: php

	<?php
	namespace XPSPL;
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Storage.
	 * 
	 * Storage is designed to allow objects to act as a storage.
	 * 
	 * Storage provides an interface to the normal PHP functions used for
	 * transversing an array, keeping all data within a central storage.
	 * 
	 * See the PHP Manual for more information regarding the functions used
	 * in Storage.
	 */
	class Storage implements \ArrayAccess, \Iterator {
	
	    /**
	     * The data storage.
	     *
	     * @var  array
	     */
	    protected $_storage = [];
	
	    /**
	     * Returns the current storage array.
	     * 
	     * @return  array
	     */
	    public function get_storage(/* ... */)
	    {
	        return $this->_storage;
	    }
	
	    /**
	     * Merge an array with the current storage.
	     * 
	     * @return  void
	     */
	    public function merge($array)
	    {
	        $this->_storage += $array;
	    }
	
	    /**
	     * Apply the given function to every node in storage.
	     * 
	     * @param  callable  $func
	     * 
	     * @return  void
	     */
	    public function walk($func)
	    {
	        return array_walk($this->_storage, $func);
	    }
	
	    /**
	     * Frees the storage.
	     */
	    public function free(/* ... */)
	    {
	        unset($this->_storage);
	        $this->_storage = [];
	    }
	
	    /**
	     * Procedures.
	     *
	     * Method declares for interfaces ArrayAccess and Iterator.
	     */
	    public function count(/* ... */)
	    {
	        return count($this->_storage);
	    }
	    public function current(/* ... */) 
	    {
	        return current($this->_storage);
	    }
	    public function end(/* ... */)
	    {
	        return end($this->_storage);
	    }
	    public function key(/* ... */)
	    {
	        return key($this->_storage);
	    }
	    public function next(/* ... */) 
	    {
	        return next($this->_storage);
	    }
	    public function prev(/* ... */)
	    {
	        return prev($this->_storage);
	    }
	    public function reset(/* ... */) 
	    {
	        return reset($this->_storage);
	    }
	    public function valid(/* ... */)
	    {
	        return current($this->_storage) !== false;
	    }
	    public function offsetExists($offset)
	    {
	        return isset($this->_storage[$offset]);
	    }
	    public function offsetSet($offset, $value)
	    {
	        $this->_storage[$offset] = $value;
	    }
	    public function offsetGet($offset)
	    {
	        return $this->_storage[$offset];
	    }
	    public function offsetUnset($offset)
	    {
	        unset($this->_storage[$offset]);
	    }
	    public function rewind(/* ... */)
	    {
	        return reset($this->_storage);
	    }
	}

Last updated on 01/13/14 04:48pm