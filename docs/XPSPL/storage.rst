.. /storage.php generated using docpx on 07/11/13 12:02am


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




Last updated on 07/11/13 12:02am