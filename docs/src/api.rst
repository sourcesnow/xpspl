.. /api.php generated using docpx on 01/16/13 03:03am


signal
======

.. function:: signal($signal, $callable)


    Creates a new signal handler.

    :param string|integer|object $signal: Signal to attach the handle.
    :param object $callable: Callable

    :rtype: object|boolean Handle, boolean if error



null_exhaust
============

.. function:: null_exhaust($handle)


    Creates a never exhausting signal handler.

    :param callable|handle $handle: PHP Callable or \XPSPL\Handle object.

    :rtype: object Handle



high_priority
=============

.. function:: high_priority($handle)


    Creates or sets a handle with high priority.

    :param callable|handle $handle: PHP Callable or \XPSPL\Handle object.

    :rtype: object Handle



low_priority
============

.. function:: low_priority($handle)


    Creates or sets a handle with low priority.

    :param callable|handle $handle: PHP Callable or \XPSPL\Handle object.

    :rtype: object Handle



priority
========

.. function:: priority($handle, $priority)


    Sets a handle priority.

    :param callable|handle $handle: PHP Callable or \XPSPL\Handle object.
    :param integer $priority: Priority

    :rtype: object Handle



remove_handle
=============

.. function:: remove_handle($signal, $handle)


    Remove a sig handler.

    :param string|integer|object $signal: Signal handle is attached to.
    :param object $handle: Handle instance.

    :rtype: void 



emit
====

.. function:: emit($signal, [$event = false])


    Signals an event.

    :param string|integer|object $signal: Signal or a signal instance.
    :param array $vars: Array of variables to pass the handles.
    :param object $event: Event

    :rtype: object \XPSPL\Event



signal_history
==============

.. function:: signal_history()


    Returns the signal history.

    :rtype: array 



register_signal
===============

.. function:: register_signal($signal)


    Registers a signal in the processor.

    :param string|integer|object $signal: Signal

    :rtype: object Queue



search_signals
==============

.. function:: search_signals($signal, [$index = false])


    Searches for a signal in storage returning its storage node if found,
    optionally the index can be returned.

    :param string|int|object $signal: Signal to search for.
    :param boolean $index: Return the index of the signal.

    :rtype: null|array [signal, queue]



loop
====

.. function:: loop()


    Starts the XPSPL loop.

    :rtype: void 



shutdown
========

.. function:: shutdown()


    Sends the loop the shutdown signal.

    :rtype: void 



import
======

.. function:: import($name, [$dir = false])


    Import a module.

    :param string $name: Module name.
    :param string|null $dir: Location of the module.

    :rtype: void 



before
======

.. function:: before($signal, $handle)


    Registers a function to interrupt the signal stack before a signal fires,
    allowing for manipulation of the event before it is passed to handles.

    :param string|object $signal: Signal instance or class name
    :param object $handle: Handle to execute

    :rtype: boolean True|False false is failure



after
=====

.. function:: after($signal, $handle)


    Registers a function to interrupt the signal stack after a signal fires.
    allowing for manipulation of the event after it is passed to handles.

    :param string|object $signal: Signal instance or class name
    :param object $handle: Handle to execute

    :rtype: boolean True|False false is failure



XPSPL
=====

.. function:: XPSPL()


    Returns the XPSPL processor.

    :rtype: object XPSPL\Processor



clean
=====

.. function:: clean([$history = false])


    Cleans any exhausted signal queues from the processor.

    :param boolean $history: Erase any history of the signals cleaned.

    :rtype: void 



delete_signal
=============

.. function:: delete_signal($signal, [$history = false])


    Delete a signal from the processor.

    :param string|object|int $signal: Signal to delete.
    :param boolean $history: Erase any history of the signal.

    :rtype: boolean 



erase_signal_history
====================

.. function:: erase_signal_history($signal)


    Erases any history of a signal.

    :param string|object $signal: Signal to be erased from history.

    :rtype: void 



disable_signaled_exceptions
===========================

.. function:: disable_signaled_exceptions([$history = false])


    Disables the exception handler.

    :param boolean $history: Erase any history of exceptions signaled.

    :rtype: void 



erase_history
=============

.. function:: erase_history()


    Cleans out the entire event history.

    :rtype: void 



save_signal_history
===================

.. function:: save_signal_history($flag)


    Sets the flag for storing the event history.

    :param boolean $flag: 

    :rtype: void 



listen
======

.. function:: listen($listener)


    Registers a new event listener object in the processor.

    :param object $listener: The event listening object

    :rtype: void 



dir_include
===========

.. function:: dir_include($dir, [$listen = false, [$path = false]])


    Performs a inclusion of the entire directory content, including 
    subdirectories, with the option to start a listener once the file has been 
    included.

    :param string $dir: Directory to include.
    :param boolean $listen: Start listeners.
    :param string $path: Path to ignore when starting listeners.

    :rtype: void 



$i
==

.. function:: $i()


    This is some pretty narly code but so far the fastest I have been able 
    to get this to run.



current_signal
==============

.. function:: current_signal([$offset = false])


    Returns the current signal in execution.

    :param integer $offset: In memory hierarchy offset +/-.

    :rtype: object 



current_event
=============

.. function:: current_event([$offset = false])


    Returns the current event in execution.

    :param integer $offset: In memory hierarchy offset +/-.

    :rtype: object 



on_shutdown
===========

.. function:: on_shutdown($function)


    Call the provided function on processor shutdown.

    :param callable|object $function: Function or handle object

    :rtype: object \XPSPL\Handle



on_start
========

.. function:: on_start($function)


    Call the provided function on processor start.

    :param callable|object $function: Function or handle object

    :rtype: object \XPSPL\Handle



XPSPL_flush
===========

.. function:: XPSPL_flush()


    Empties the storage, history and clears the current state.

    :rtype: void 



