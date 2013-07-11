.. /idle.php generated using docpx on 07/11/13 12:02am


Class - XPSPL\\Idle
*******************

Idle

Methods
-------

idle
++++

.. function:: idle($processor)


    Idle's the processor.
    
    This function is purely responsible for providing the processor the ability
    to idle.
    
    This method is provided an instance of the processor which is wishing to 
    idle and should respect the processors current specifications for the amount
    of time that it needs to idle if it knows.
    
    You have been warned ...
    
    Creating a function that does not properly idle, does not respect the
    processor specs or is poorly designed will result in terrible performance, 
    unexpected results and can be damaging to your system ... use caution.

    :param object: \XPSPL\Processor

    :rtype: void 



get_priority
++++++++++++

.. function:: get_priority()


    Returns the priority of this idle function.

    :rtype: integer 



allow_override
++++++++++++++

.. function:: allow_override()


    Return if this function allows itself to be overwritten in the limit
    is met or exceeded.

    :rtype: boolean 



override
++++++++

.. function:: override($idle)


    Returns if the given function can override this in the processor.

    :param object: Idle function object

    :rtype: boolean 




Last updated on 07/11/13 12:02am