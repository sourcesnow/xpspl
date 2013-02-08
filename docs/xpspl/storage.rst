.. storage.php generated using docpx on 02/08/13 05:30pm


Class - XPSPL\\Storage
**********************

Storage.

The Storage trait is designed to allow objects to act as a storage, the
trait only provides an interface to the normal PHP functions used for
transversing an array, keeping all data within a central storage.

See the PHP Manual for more information regarding the functions used
in this trait.

Methods
-------

storage
+++++++

.. function:: storage()


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



sort
++++

.. function:: sort()



usort
+++++

.. function:: usort($cmp)



uasort
++++++

.. function:: uasort($cmp)



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




Last updated on 02/08/13 05:30pm