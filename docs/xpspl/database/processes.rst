.. database/processes.php generated using docpx on 02/08/13 05:30pm


Class - XPSPL\\database\\Processes
**********************************

Processes

Priority database for signal processes.

Methods
-------

__construct
+++++++++++

.. function:: __construct()


    Constructs a new Database.

    :rtype: void 



install
+++++++

.. function:: install($process)


    Installs a new process into the database.

    :param object: \XPSPL\Process

    :rtype: void 



delete
++++++

.. function:: delete($process)


    Deletes a process from the database.

    :param object: \XPSPL\Process

    :rtype: boolean 



merge
+++++

.. function:: merge($array)


    Merges two Processes database together.
    
    The merged into database (self) takes precedence of the merged in 
    database in FIFO.

    :param object: \XPSPL\database\Processes

    :rtype: void 




Last updated on 02/08/13 05:30pm