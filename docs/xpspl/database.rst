.. database.php generated using docpx on 01/31/13 10:43pm


Class - XPSPL\\Database
***********************

Database

A signal database.

All signals are stored in a database by their index.

Each signal stored has a copy of the signal and it's queue.

Methods
-------

__construct
+++++++++++

.. function:: __construct()


    Constructs a new Database.

    :rtype: void 



find_signal
+++++++++++

.. function:: find_signal($signal)


    Finds the signal in the database.
    
    Returns null if the signal does not exit.

    :param object: 

    :rtype: object 



register_signal
+++++++++++++++

.. function:: register_signal($signal, $queue)


    Registers a signal in the database with the given queue.

    :param object: \XPSPL\SIG
    :param object: \XPSPL\Queue

    :rtype: void 



free
++++

.. function:: free()


    Frees the database.



Class - XPSPL\\Database
***********************

Methods
-------

find_signal
+++++++++++

.. function:: find_signal($signal)


    Finds the signal in the database.
    
    Returns null if the signal does not exit.

    :param object: 

    :rtype: object 



register_signal
+++++++++++++++

.. function:: register_signal($signal, $queue)


    Registers a signal in the database with the given queue.

    :param object: \XPSPL\SIG
    :param object: \XPSPL\Queue

    :rtype: void 




Last updated on 01/31/13 10:43pm