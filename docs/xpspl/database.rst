.. database.php generated using docpx on 01/27/13 03:54pm


XPSPL\\Database
===============

Database

A signal database.

All signals are stored in a database by their index.

Each signal stored has a copy of the signal and it's queue.

Methods
+++++++

__construct
-----------

.. function:: __construct()


    Constructs a new Database.

    :rtype: void 



find_signal
-----------

.. function:: find_signal()


    Finds the signal in the database.
    
    Returns null if the signal does not exit.

    :param object: 

    :rtype: object 



register_signal
---------------

.. function:: register_signal()


    Registers a signal in the database with the given queue.

    :param object: \XPSPL\SIG
    :param object: \XPSPL\Queue

    :rtype: void 



free
----

.. function:: free()


    Frees the database.



XPSPL\\Database
===============

Methods
+++++++

find_signal
-----------

.. function:: find_signal()


    Finds the signal in the database.
    
    Returns null if the signal does not exit.

    :param object: 

    :rtype: object 



register_signal
---------------

.. function:: register_signal()


    Registers a signal in the database with the given queue.

    :param object: \XPSPL\SIG
    :param object: \XPSPL\Queue

    :rtype: void 



