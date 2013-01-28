.. processor.php generated using docpx on 01/27/13 03:54pm


XPSPL\\Processor
================

Processor

The brainpower of XPSPL.

Methods
+++++++

__construct
-----------

.. function:: __construct()


    Starts the processor.

    :rtype: void 



erase_history
-------------

.. function:: erase_history()


    Cleans out the signal history.

    :rtype: void 



wait_loop
---------

.. function:: wait_loop()


    Waits for the next signal to occur.


    :rtype: void 



_routine
--------

.. function:: _routine()


    Runs the complex signal routine for the processor loop.


    :rtype: boolean|array 



get_routine
-----------

.. function:: get_routine()


    Returns the current routine object.


    :rtype: null|object 



has_signal_exhausted
--------------------

.. function:: has_signal_exhausted()


    Determines if the given signal has exhausted.

    :param string|integer|object: 

    :rtype: boolean 



queue_exhausted
---------------

.. function:: queue_exhausted()


    Determine if all queue processs are exhausted.

    :param object: \XPSPL\Queue

    :rtype: boolean 



remove_process
--------------

.. function:: remove_process()


    Removes a signal process.

    :param mixed: Signal instance or signal.
    :param mixed: Process instance or identifier.

    :rtype: void 



flush
-----

.. function:: flush()


    Flush
    
    Resets the signal databases, the routine object and cleans the history 
    if tracked.

    :rtype: void 



listen
------

.. function:: listen()


    Listen
    
    Registers an object listener.

    :param object: XPSPL\Listener

    :rtype: void 



signal
------

.. function:: signal()


    Creates a new signal process.

    :param string|int|object: Signal to attach the process.
    :param object: Signal process

    :rtype: object|boolean Process, boolean if error



register_signal
---------------

.. function:: register_signal()


    Registers a signal into the processor.

    :param string|integer|object: Signal

    :rtype: boolean|object false|XPSPL\Queue



get_database
------------

.. function:: get_database()


    Returns the signal database for the given signal.

    :param object: 

    :rtype: array 



find_signal
-----------

.. function:: find_signal()


    Finds an installed signal.

    :param object: SIG

    :rtype: object Queue



evaluate_signals
----------------

.. function:: evaluate_signals()


    Perform the evaluation for all registered complex signals.

    :param string|object|int: Signal to evaluate

    :rtype: array|null [[[signal, queue], eval_return]]



emit
----

.. function:: emit()


    Emits a signal.

    :param mixed: Signal instance or signal.
    :param object|null: Context to execute

    :rtype: object Event



_execute
--------

.. function:: _execute()


    Executes a queue.
    
    This will monitor the event status and break on a HALT or ERROR state.
    
    Executes interruption functions before and after queue execution.

    :param object: Signal instance.
    :param object: Queue instance.
    :param boolean: Run the interrupt functions.

    :rtype: void 



_queue_execute
--------------

.. function:: _queue_execute()


    Executes a queue.
    
    If XPSPL_EXHAUSTION_PURGE is true processs will be purged once they 
    reach exhaustion.

    :param object: XPSPL\Queue
    :param object: XPSPL\Signal

    :rtype: void 



_func_exec
----------

.. function:: _func_exec()


    Executes a callable processor function.

    :param callable: Function to execute
    :param object: Signal context to execute within

    :rtype: boolean 



signal_history
--------------

.. function:: signal_history()


    Returns the signal history.

    :rtype: array 



shutdown
--------

.. function:: shutdown()


    Sends the processor the shutdown signal.

    :rtype: void 



before
------

.. function:: before()


    Registers a function to interrupt the signal stack before a signal emits.
    
    This allows for manipulation of the signal before it is passed to any 
    processes.

    :param string|object: Signal instance or class name
    :param object: Process to execute

    :rtype: boolean True|False false is failure



after
-----

.. function:: after()


    Registers a function to interrupt the signal stack after a signal emits.
    
    This allows for analysis of a signal after execution in processes.

    :param string|object: Signal instance or class name
    :param object: Process to execute

    :rtype: boolean True|False false is failure



_signal_interrupt
-----------------

.. function:: _signal_interrupt()


    Registers a function to interrupt the signal stack before or after a 
    signal emits.

    :param string|object: 
    :param object: Process to execute
    :param int|null: Interuption location. INTERUPT_PRE|INTERUPT_POST

    :rtype: boolean True|False false is failure



_get_int_database
-----------------

.. function:: _get_int_database()


    Returns the interruption storage database.

    :param integer: The interruption type

    :rtype: object \XPSPL\Database

    :since:  



_interrupt
----------

.. function:: _interrupt()


    Process signal interuption functions.

    :param object: Signal
    :param int: Interupt type

    :rtype: boolean 



clean
-----

.. function:: clean()


    Cleans any exhausted signals from the processor.

    :param boolean: Erase any history of the signals cleaned.

    :rtype: void 

    :todo:  



delete_signal
-------------

.. function:: delete_signal()


    Delete a signal from the processor.

    :param string|object|int: Signal to delete.
    :param boolean: Erase any history of the signal.

    :rtype: boolean 



erase_signal_history
--------------------

.. function:: erase_signal_history()


    Erases any history of a signal.

    :param string|object: Signal to be erased from history.

    :rtype: void 



set_signal_history
------------------

.. function:: set_signal_history()


    Sets the flag for storing the signal history.
    
    Note that this will delete the current if reset.

    :param boolean: 

    :rtype: void 



current_signal
--------------

.. function:: current_signal()


    Returns the current signal in execution.

    :param integer: In memory hierarchy offset +/-.

    :rtype: object 





Constants
+++++++++

INTERRUPT_PRE
=============

Interruption before emittion

INTERRUPT_POST
==============

Interruption after emittion

