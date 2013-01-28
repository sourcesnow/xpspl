.. sig.php generated using docpx on 01/27/13 03:54pm


XPSPL\\SIG
==========

SIG

The SIG is the representation of a signal.

Every SIG object is represented as an index, with each index being a valid 
indexable value.

By default a SIG will generate it's index based on its name to allow for a 
class based signal architecture.

The SIG object allows for unique signals by declaring a subclass with the 
property of unique set as true.

It is also possible to provide the SIG an index value to represent itself as.

.. note::
   
   When a SIG is declared unique any index assigned to the SIG on construct 
   will be ignored.

Methods
+++++++

__construct
-----------

.. function:: __construct()


    Constructs a new signal.

    :param string|integer: Signal Index

    :rtype: void 



get_index
---------

.. function:: get_index()


    Returns the signal index.

    :rtype: boolean 



set_result
----------

.. function:: set_result()


    Sets the result of the signal.

    :param mixed: 



get_result
----------

.. function:: get_result()


    Returns the result of the signal.

    :rtype: mixed 



halt
----

.. function:: halt()


    Halts the signal execution.

    :rtype: void 



is_child
--------

.. function:: is_child()


    Determines if the signal is a child of another signal.

    :rtype: boolean 



set_parent
----------

.. function:: set_parent()


    Sets the parent signal.

    :param object: \XPSPL\Signal

    :rtype: void 



get_parent
----------

.. function:: get_parent()


    Retrieves this signal's parent.

    :rtype: null|object 



__get
-----

.. function:: __get()


    Get a variable in the signal.

    :param mixed: Variable name.

    :rtype: mixed|null 



__isset
-------

.. function:: __isset()


    Checks for a variable in the signal.

    :param mixed: Variable name.

    :rtype: boolean 



__set
-----

.. function:: __set()


    Set a variable in the signal.

    :param string: Name of variable
    :param mixed: Value to variable

    :rtype: boolean True



__unset
-------

.. function:: __unset()


    Deletes a variable in the signal.

    :param mixed: Variable name.

    :rtype: boolean 



