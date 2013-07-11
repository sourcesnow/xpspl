.. /api.php generated using docpx on 07/11/13 12:02am


Function - clean
****************


.. function:: clean([$history = false])


    Cleans any exhausted signal queues from the processor.

    :param boolean: Erase any history of the signals cleaned.

    :rtype: void 



Function - delete_signal
************************


.. function:: delete_signal($signal, [$history = false])


    Delete a signal from the processor.

    :param string|object|int: Signal to delete.
    :param boolean: Erase any history of the signal.

    :rtype: boolean 



Function - erase_signal_history
*******************************


.. function:: erase_signal_history($signal)


    Erases any history of a signal.

    :param string|object: Signal to be erased from history.

    :rtype: void 



Function - disable_signaled_exceptions
**************************************


.. function:: disable_signaled_exceptions()


    Disables the exception process.

    :param boolean: Erase any history of exceptions signaled.

    :rtype: void 



Function - erase_history
************************


.. function:: erase_history()


    Cleans out the entire event history.

    :rtype: void 



Function - set_signal_history
*****************************


.. function:: set_signal_history($flag)


    Sets the flag for storing the event history.

    :param boolean: 

    :rtype: void 



Function - listen
*****************


.. function:: listen($listener)


    Registers a new event listener object in the processor.

    :param object: The event listening object

    :rtype: void 



Function - dir_include
**********************


.. function:: dir_include($dir, [$listen = false, [$path = false]])


    Performs a inclusion of the entire directory content, including 
    subdirectories, with the option to start a listener once the file has been 
    included.

    :param string: Directory to include.
    :param boolean: Start listeners.
    :param string: Path to ignore when starting listeners.

    :rtype: void 



Function - current_signal
*************************


.. function:: current_signal([$offset = false])


    Returns the current signal in execution.

    :param integer: In memory hierarchy offset +/-.

    :rtype: object 



Function - current_event
************************


.. function:: current_event()


    Returns the current event in execution.

    :param integer: In memory hierarchy offset +/-.

    :rtype: object 



Function - on_shutdown
**********************


.. function:: on_shutdown($function)


    Call the provided function on processor shutdown.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process



Function - on_start
*******************


.. function:: on_start($function)


    Call the provided function on processor start.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process



Function - XPSPL_flush
**********************


.. function:: XPSPL_flush()


    Empties the storage, history and clears the current state.

    :rtype: void 




Last updated on 07/11/13 12:02am