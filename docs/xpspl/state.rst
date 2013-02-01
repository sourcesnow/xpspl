.. state.php generated using docpx on 01/31/13 10:43pm


Trait - XPSPL\\State
********************

State

Methods
-------

__construct
+++++++++++

.. function:: __construct()


    Constructs a new state object.

    :rtype: void 



get_state
+++++++++

.. function:: get_state()


    Returns the current event state.

    :rtype: integer Current state of this event.



set_state
+++++++++

.. function:: set_state()


    Set the object state.

    :param int: State of the object.

    :throws InvalidArgumentException: 

    :rtype: void 



Constants
---------

STATE_DECLARED
++++++++++++++
Declared for use.

STATE_RUNNING
+++++++++++++
Currently running in execution.

STATE_EXITED
++++++++++++
Execution finised.

STATE_ERROR
+++++++++++
Error encountered.

STATE_RECYCLED
++++++++++++++
Successfully ran through a lifecycle and reused.

STATE_RECOVERED
+++++++++++++++
Corrupted during runtime execution and recovery was succesful.

STATE_HALTED
++++++++++++
The object has declared to stop any further execution.


Last updated on 01/31/13 10:43pm