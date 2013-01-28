.. api.php generated using docpx on 01/27/13 03:54pm


signal_history
==============

.. function:: signal_history()


    Returns the signal history.

    :rtype: array 



register_signal
===============

.. function:: register_signal()


    Registers a signal in the processor.

    :param string|integer|object: Signal

    :rtype: object Queue



search_signals
==============

.. function:: search_signals()


    Searches for a signal in storage returning its storage node if found,
    optionally the index can be returned.

    :param string|int|object: Signal to search for.
    :param boolean: Return the index of the signal.

    :rtype: null|array [signal, queue]



wait_loop
=========

.. function:: wait_loop()


    Starts the XPSPL wait loop.

    :rtype: void 



shutdown
========

.. function:: shutdown()


    Sends the loop the shutdown signal.

    :rtype: void 



import
======

.. function:: import()


    Import a module.

    :param string: Module name.
    :param string|null: Location of the module.

    :rtype: void 



before
======

.. function:: before()


    Registers a function to interrupt the signal stack before a signal fires,
    allowing for manipulation of the event before it is passed to processs.

    :param string|object: Signal instance or class name
    :param object: Process to execute

    :rtype: boolean True|False false is failure



after
=====

.. function:: after()


    Registers a function to interrupt the signal stack after a signal fires.
    allowing for manipulation of the event after it is passed to processs.

    :param string|object: Signal instance or class name
    :param object: Process to execute

    :rtype: boolean True|False false is failure



XPSPL
=====

.. function:: XPSPL()


    Returns the XPSPL processor.

    :rtype: object XPSPL\Processor



clean
=====

.. function:: clean()


    Cleans any exhausted signal queues from the processor.

    :param boolean: Erase any history of the signals cleaned.

    :rtype: void 



delete_signal
=============

.. function:: delete_signal()


    Delete a signal from the processor.

    :param string|object|int: Signal to delete.
    :param boolean: Erase any history of the signal.

    :rtype: boolean 



erase_signal_history
====================

.. function:: erase_signal_history()


    Erases any history of a signal.

    :param string|object: Signal to be erased from history.

    :rtype: void 



disable_signaled_exceptions
===========================

.. function:: disable_signaled_exceptions()


    Disables the exception process.

    :param boolean: Erase any history of exceptions signaled.

    :rtype: void 



erase_history
=============

.. function:: erase_history()


    Cleans out the entire event history.

    :rtype: void 



set_signal_history
==================

.. function:: set_signal_history()


    Sets the flag for storing the event history.

    :param boolean: 

    :rtype: void 



listen
======

.. function:: listen()


    Registers a new event listener object in the processor.

    :param object: The event listening object

    :rtype: void 



dir_include
===========

.. function:: dir_include()


    Performs a inclusion of the entire directory content, including 
    subdirectories, with the option to start a listener once the file has been 
    included.

    :param string: Directory to include.
    :param boolean: Start listeners.
    :param string: Path to ignore when starting listeners.

    :rtype: void 



current_signal
==============

.. function:: current_signal()


    Returns the current signal in execution.

    :param integer: In memory hierarchy offset +/-.

    :rtype: object 



current_event
=============

.. function:: current_event()


    Returns the current event in execution.

    :param integer: In memory hierarchy offset +/-.

    :rtype: object 



on_shutdown
===========

.. function:: on_shutdown()


    Call the provided function on processor shutdown.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process



on_start
========

.. function:: on_start()


    Call the provided function on processor start.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process



XPSPL_flush
===========

.. function:: XPSPL_flush()


    Empties the storage, history and clears the current state.

    :rtype: void 



