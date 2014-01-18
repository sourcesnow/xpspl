.. /database/signals.php generated using docpx on 07/11/13 12:02am


Class - XPSPL\\database\\Signals
********************************

Signal Database

A database of signals.

All signals are stored in a database by their index.

Each signal stored has a copy of the signal and it's process database.

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

.. function:: register_signal($signal, $database)


    Registers a signal in the database with the given processes database.

    :param object: \XPSPL\SIG
    :param object: \XPSPL\database\Processes

    :rtype: void 



delete_signal
+++++++++++++

.. function:: delete_signal($signal)


    Deletes a signal from the database.

    :param object: \XPSPL\SIG

    :rtype: void 



find_processes_database
+++++++++++++++++++++++

.. function:: find_processes_database($signal)


    Finds and returns the given signals processes database.

    :param object: \XPSPL\Sig

    :rtype: null|object Processes




Last updated on 07/11/13 12:02am