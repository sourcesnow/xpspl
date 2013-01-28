.. state.php generated using docpx on 01/27/13 03:54pm


XPSPL\\__construct
==================

.. function:: XPSPL\__construct()


    Constructs a new state object.

    :rtype: void 



XPSPL\\get_state
================

.. function:: XPSPL\get_state()


    Returns the current event state.

    :rtype: integer Current state of this event.



XPSPL\\set_state
================

.. function:: XPSPL\set_state()


    Set the object state.

    :param int: State of the object.

    :throws InvalidArgumentException: 

    :rtype: void 



STATE_DECLARED
==============

Declared for use.

STATE_RUNNING
=============

Currently running in execution.

STATE_EXITED
============

Execution finised.

STATE_ERROR
===========

Error encountered.

STATE_RECYCLED
==============

Successfully ran through a lifecycle and reused.

STATE_RECOVERED
===============

Corrupted during runtime execution and recovery was succesful.

STATE_HALTED
============

The object has declared to stop any further execution.

