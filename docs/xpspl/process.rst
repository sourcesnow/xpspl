.. process.php generated using docpx on 02/08/13 05:30pm


Class - XPSPL\\Process
**********************

Process

A process is the callable which will execute when a signal is emitted.

Methods
-------

__construct
+++++++++++

.. function:: __construct($callable, [$exhaust = 1, [$priority = 10]])


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




Last updated on 02/08/13 05:30pm