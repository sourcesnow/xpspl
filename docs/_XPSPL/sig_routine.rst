.. /sig_routine.php generated using docpx on 07/11/13 12:02am


Class - XPSPL\\SIG_Routine
**************************

SIG_Routine

Methods
-------

routine
+++++++

.. function:: routine($routine)


    Runs the routine calculation.
    
    The method is provided a single routine object for providing the 
    processor information.

    :param object: Processor routine.

    :rtype: void 



idle
++++

.. function:: idle($processor)


    Runs the routines idle function.
    
    This method was added in v4.0.0 as a means for the processor to 
    communicate to the routine to begin idling.
    
    This only provides a transport layer for going from the processor into 
    the signal.



get_idle
++++++++

.. function:: get_idle()


    Returns the idle object for this routine.

    :rtype: object \XPSPL\Idle



set_idle
++++++++

.. function:: set_idle($idle)


    Sets the idle object for this routine.

    :rtype: object \XPSPL\Idle




Last updated on 07/11/13 12:02am