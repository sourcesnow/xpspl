.. api.php generated using docpx on 01/31/13 10:43pm


Function - signal_history
*************************

signal_history
==============

.. function:: signal_history()


    Returns the signal history.

    :rtype: array 



Function - register_signal
**************************

register_signal
===============

.. function:: register_signal($signal)


    Registers a signal in the processor.

    :param string|integer|object: Signal

    :rtype: object Queue



Function - search_signals
*************************

search_signals
==============

.. function:: search_signals($signal, [$index = false])


    Searches for a signal in storage returning its storage node if found,
    optionally the index can be returned.

    :param string|int|object: Signal to search for.
    :param boolean: Return the index of the signal.

    :rtype: null|array [signal, queue]



Function - wait_loop
********************

wait_loop
=========

.. function:: wait_loop()


    Starts the XPSPL wait loop.

    :rtype: void 



Function - shutdown
*******************

shutdown
========

.. function:: shutdown()


    Sends the loop the shutdown signal.

    :rtype: void 



Function - import
*****************

import
======

.. function:: import($name, [$dir = false])


    Import a module.

    :param string: Module name.
    :param string|null: Location of the module.

    :rtype: void 



Function - before
*****************

before
======

.. function:: before($signal, $process)


    Registers a function to interrupt the signal stack before a signal fires,
    allowing for manipulation of the event before it is passed to processs.

    :param string|object: Signal instance or class name
    :param object: Process to execute

    :rtype: boolean True|False false is failure



Function - after
****************

after
=====

.. function:: after($signal, $process)


    Registers a function to interrupt the signal stack after a signal fires.
    allowing for manipulation of the event after it is passed to processs.

    :param string|object: Signal instance or class name
    :param object: Process to execute

    :rtype: boolean True|False false is failure



Function - XPSPL
****************

XPSPL
=====

.. function:: XPSPL()


    Returns the XPSPL processor.

    :rtype: object XPSPL\Processor



Function - clean
****************

clean
=====

.. function:: clean([$history = false])


    Cleans any exhausted signal queues from the processor.

    :param boolean: Erase any history of the signals cleaned.

    :rtype: void 



Function - delete_signal
************************

delete_signal
=============

.. function:: delete_signal($signal, [$history = false])


    Delete a signal from the processor.

    :param string|object|int: Signal to delete.
    :param boolean: Erase any history of the signal.

    :rtype: boolean 



Function - erase_signal_history
*******************************

erase_signal_history
====================

.. function:: erase_signal_history($signal)


    Erases any history of a signal.

    :param string|object: Signal to be erased from history.

    :rtype: void 



Function - disable_signaled_exceptions
**************************************

disable_signaled_exceptions
===========================

.. function:: disable_signaled_exceptions([$history = false])


    Disables the exception process.

    :param boolean: Erase any history of exceptions signaled.

    :rtype: void 



Function - erase_history
************************

erase_history
=============

.. function:: erase_history()


    Cleans out the entire event history.

    :rtype: void 



Function - set_signal_history
*****************************

set_signal_history
==================

.. function:: set_signal_history($flag)


    Sets the flag for storing the event history.

    :param boolean: 

    :rtype: void 



Function - listen
*****************

listen
======

.. function:: listen($listener)


    Registers a new event listener object in the processor.

    :param object: The event listening object

    :rtype: void 



Function - dir_include
**********************

dir_include
===========

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

current_signal
==============

.. function:: current_signal([$offset = false])


    Returns the current signal in execution.

    :param integer: In memory hierarchy offset +/-.

    :rtype: object 



Function - current_event
************************

current_event
=============

.. function:: current_event([$offset = false])


    Returns the current event in execution.

    :param integer: In memory hierarchy offset +/-.

    :rtype: object 



Function - on_shutdown
**********************

on_shutdown
===========

.. function:: on_shutdown($function)


    Call the provided function on processor shutdown.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process



Function - on_start
*******************

on_start
========

.. function:: on_start($function)


    Call the provided function on processor start.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process



Function - XPSPL_flush
**********************

XPSPL_flush
===========

.. function:: XPSPL_flush()


    Empties the storage, history and clears the current state.

    :rtype: void 




Last updated on 01/31/13 10:43pm