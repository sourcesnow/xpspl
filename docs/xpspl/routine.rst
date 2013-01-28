.. routine.php generated using docpx on 01/27/13 03:54pm


XPSPL\\Routine
==============

Routine

The routine class is used by the processor during the routine calculation for
storing the idle functions and the signals which should be triggered in the
next loop.

This was added due to the current loop not providing a simple means for
objects inside the loop determining what has happened within the routine
calculation and the functionality required for the upgraded idle required
more complex algorithms which would not fit well inside the entire routine
loop method.

Methods
+++++++

get_signals
-----------

.. function:: get_signals()


    Returns the signals to trigger in the loop.

    :rtype: array 



get_idle
--------

.. function:: get_idle()


    Returns the object to idle the processor.
    
    This will only return a single object which has the greatest priority.

    :rtype: integer 



get_idles_available
-------------------

.. function:: get_idles_available()


    Returns the objects createed to idle the processor.

    :rtype: integer 



add_idle
--------

.. function:: add_idle()


    Adds a new function to idle the engine.

    :param object: Idle

    :rtype: void 



add_signal
----------

.. function:: add_signal()


    Adds a signal to trigger in the loop.

    :rtype: array 



reset
-----

.. function:: reset()


    Resets the routine after the processor has used it.

    :rtype: void 



