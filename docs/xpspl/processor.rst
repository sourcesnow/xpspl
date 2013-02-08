.. processor.php generated using docpx on 02/08/13 05:30pm


Class - XPSPL\\Processor
************************

Processor

The brainpower of XPSPL.

Methods
-------

__construct
+++++++++++

.. function:: __construct()


    Starts the processor.

    :rtype: void 



erase_history
+++++++++++++

.. function:: erase_history()


    Cleans out the signal history.

    :rtype: void 



anaylze_runtime
+++++++++++++++

.. function:: anaylze_runtime($sig_awake)


    Analyzes the processor runtime and shutdowns when no activity is 
    detected.

    :param object: SIG_Awake

    :rtype: void 



wait_loop
+++++++++

.. function:: wait_loop()


    Waits for the next signal to occur.


    :rtype: void 



_routine
++++++++

.. function:: _routine()


    Runs the signal routine for the processor loop.


    :rtype: boolean|array 



get_routine
+++++++++++

.. function:: get_routine()


    Returns the current routine object.


    :rtype: null|object 



has_signal_exhausted
++++++++++++++++++++

.. function:: has_signal_exhausted($signal)


    Determines if the given signal has exhausted.

    :param object: \XPSPL\SIG

    :rtype: boolean 



are_processes_exhausted
+++++++++++++++++++++++

.. function:: are_processes_exhausted($database)


    Determine if the given database processes are exhausted.

    :param object: \XPSPL\database\Processes

    :rtype: boolean 



remove_process
++++++++++++++

.. function:: remove_process($signal, $process)


    Removes a signal process.

    :param mixed: Signal instance or signal.
    :param mixed: Process instance or identifier.

    :rtype: boolean 



flush
+++++

.. function:: flush()


    Flush
    
    Resets the signal databases, the routine object and cleans the history 
    if tracked.

    :rtype: void 



listen
++++++

.. function:: listen($listener)


    Listen
    
    Registers an object listener.

    :param object: XPSPL\Listener

    :rtype: void 



signal
++++++

.. function:: signal($signal, $process)


    Creates a new signal process.

    :param string|int|object: Signal to attach the process.
    :param object: Signal process

    :rtype: object|boolean Process, boolean if error



register_signal
+++++++++++++++

.. function:: register_signal($signal)


    Registers a signal into the processor.

    :param string|integer|object: Signal

    :rtype: boolean|object false|XPSPL\database\Processes



get_database
++++++++++++

.. function:: get_database($signal)


    Returns the signal database for the given signal.

    :param object: 

    :rtype: array 



find_signal_database
++++++++++++++++++++

.. function:: find_signal_database($signal)


    Finds an installed signals processes database.

    :param object: SIG

    :rtype: null|object \XPSPL\database\Signals



evaluate_signals
++++++++++++++++

.. function:: evaluate_signals($signal)


    Perform the evaluation for all registered complex signals.

    :param string|object|int: Signal to evaluate

    :rtype: array|null [[[signal, queue], eval_return]]



emit
++++

.. function:: emit($signal)


    Emits a signal.

    :param object: \XPSPL\SIG

    :rtype: object Event



_execute
++++++++

.. function:: _execute($signal, $db, [$interrupt = true])


    Executes a database of processes.
    
    This will monitor the signal status and break on a HALT or ERROR state.

    :param object: \XPSPL\SIG
    :param object: \XPSPL\database\Processes
    :param boolean: Run the interrupt functions.

    :rtype: void 



_processes_execute
++++++++++++++++++

.. function:: _processes_execute($signal, $db)


    Executes a processes database.
    
    If XPSPL_EXHAUSTION_PURGE is true processes will be purged once they 
    reach exhaustion.

    :param object: XPSPL\Queue
    :param object: \XPSPL\database\Processes

    :rtype: void 



_process_exec
+++++++++++++

.. function:: _process_exec($signal, [$function = false])


    Executes a callable processor function.
    
    This currently uses a hand built method in PHP ... really this 
    should be done in C within the core ... but call_user_* is slow ...

    :param object: \XPSPL\SIG
    :param mixed: Callable variable

    :rtype: boolean 



signal_history
++++++++++++++

.. function:: signal_history()


    Returns the signal history.

    :rtype: array 



shutdown
++++++++

.. function:: shutdown()


    Sends the processor the shutdown signal.

    :rtype: void 



before
++++++

.. function:: before($signal, $process)


    Registers a function to interrupt the signal stack before a signal emits.
    
    This allows for manipulation of the signal before it is passed to any 
    processes.

    :param string|object: Signal instance or class name
    :param object: Process to execute

    :rtype: boolean True|False false is failure



after
+++++

.. function:: after($signal, $process)


    Registers a function to interrupt the signal stack after a signal emits.
    
    This allows for analysis of a signal after execution in processes.

    :param string|object: Signal instance or class name
    :param object: Process to execute

    :rtype: boolean True|False false is failure



_signal_interrupt
+++++++++++++++++

.. function:: _signal_interrupt($signal, $process, [$interrupt = false])


    Registers a function to interrupt the signal stack before or after a 
    signal emits.

    :param string|object: 
    :param object: Process to execute
    :param int|null: Interuption location. INTERUPT_PRE|INTERUPT_POST

    :rtype: boolean True|False false is failure



_get_int_database
+++++++++++++++++

.. function:: _get_int_database($interrupt)


    Returns the interruption storage database.

    :param integer: The interruption type

    :rtype: object \XPSPL\Database

    :since:  



_interrupt
++++++++++

.. function:: _interrupt($signal, [$interrupt = false])


    Process signal interuption functions.

    :param object: Signal
    :param int: Interupt type

    :rtype: boolean 



clean
+++++

.. function:: clean([$history = false])


    Cleans any exhausted signals from the processor.

    :param boolean: Erase any history of the signals cleaned.

    :rtype: void 

    :todo:  



delete_signal
+++++++++++++

.. function:: delete_signal($signal, [$history = false])


    Delete a signal from the processor.

    :param string|object|int: Signal to delete.
    :param boolean: Erase any history of the signal.

    :rtype: boolean 



erase_signal_history
++++++++++++++++++++

.. function:: erase_signal_history($signal)


    Erases any history of a signal.

    :param string|object: Signal to be erased from history.

    :rtype: void 



set_signal_history
++++++++++++++++++

.. function:: set_signal_history($flag)


    Sets the flag for storing the signal history.
    
    Note that this will delete the current if reset.

    :param boolean: 

    :rtype: void 



current_signal
++++++++++++++

.. function:: current_signal([$offset = 1])


    Returns the current signal in execution.

    :param integer: In memory hierarchy offset +/-.

    :rtype: object 



Constants
---------

INTERRUPT_PRE
+++++++++++++
Interruption before emittion

INTERRUPT_POST
++++++++++++++
Interruption after emittion


Last updated on 02/08/13 05:30pm