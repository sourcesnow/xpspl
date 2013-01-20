.. /processor.php generated using docpx on 01/16/13 03:03am


XPSPL\Processor
===============


Processor

The brainpower of XPSPL.

As of v0.3.0 the loop is now run in respect to the currently available handles,
this prevents the processor from running contionusly forever when there isn't anything
that it needs to do.

To achieve this the processor uses routines for calculating when to run and 
shutdowns when no more are available.

The queue storage has also been improved in 0.3.0, previously the storage used
a non-index and index based storage, the storage now uses only a single array.



Methods
-------

__construct
===========

.. function:: __construct([$signal_history = true])


    Starts the processor.

    :param boolean $signal_history: Store a history of all signals.

    :rtype: void 



_register_error_handler
=======================

.. function:: _register_error_handler()


    Registers the processor error signal handler.
    
    TODO
    Create a suitable error handler

    :rtype: void 



bool(false)
erase_history
=============

.. function:: erase_history()


    Cleans out the event history.

    :rtype: void 



loop
====

.. function:: loop([$ttr = false])


    Start the event loop.


Warning: Illegal string offset 'type' in /Users/prggmr/Lab/docpx/src/templates/rst/tags.template on line 43

Warning: Illegal string offset 'text' in /Users/prggmr/Lab/docpx/src/templates/rst/tags.template on line 44

    :param null|integer $ttr: Number of milliseconds to run the loop.

    :rtype: void 



bool(false)
_routine
========

.. function:: _routine()


    Runs the complex signal routine for the processor loop.


Warning: Illegal string offset 'type' in /Users/prggmr/Lab/docpx/src/templates/rst/tags.template on line 43

Warning: Illegal string offset 'text' in /Users/prggmr/Lab/docpx/src/templates/rst/tags.template on line 44

    :rtype: boolean|array 



get_routine
===========

.. function:: get_routine()


    Returns the current routine object.


Warning: Illegal string offset 'type' in /Users/prggmr/Lab/docpx/src/templates/rst/tags.template on line 43

Warning: Illegal string offset 'text' in /Users/prggmr/Lab/docpx/src/templates/rst/tags.template on line 44

    :rtype: null|object 



has_signal_exhausted
====================

.. function:: has_signal_exhausted($signal)


    Determines if the given signal has exhausted.

    :param string|integer|object $queue: 

    :rtype: boolean 



queue_exhausted
===============

.. function:: queue_exhausted($queue)


    Determine if all queue handles are exhausted.

    :param object $queue: \XPSPL\Queue

    :rtype: boolean 



remove_handle
=============

.. function:: remove_handle($signal, $handle)


    Removes a signal handler.

    :param mixed $signal: Signal instance or signal.
    :param mixed $handle: Handle instance or identifier.

    :rtype: void 



flush
=====

.. function:: flush()


    Empties the storage, history and clears the current state.

    :rtype: void 



listen
======

.. function:: listen($listener)


    Registers an object listener.

    :param object $listener: XPSPL\Listener

    :rtype: void 



signal
======

.. function:: signal($signal, $handle)


    Creates a new signal handler.

    :param string|int|object $signal: Signal to attach the handle.
    :param object $callable: Signal handler

    :rtype: object|boolean Handle, boolean if error



register_signal
===============

.. function:: register_signal($signal)


    Registers a signal a new signal

    :param string|integer|object $signal: Signal

    :rtype: boolean|object false|XPSPL\Queue



search_signals
==============

.. function:: search_signals($signal, [$index = false])


    Searches for a signal in storage returning its storage queue if found,
    optionally the index can be returned.

    :param string|int|object $signal: Signal to search for.
    :param boolean $index: Return the index of the signal.

    :rtype: null|object null|Queue



evaluate_signals
================

.. function:: evaluate_signals($signal)


    Runs the evaluation for the registered complex signals using the given
    signal.

    :param string|object|int $signal: Signal to evaluate

    :rtype: array|null [[[signal, queue], eval_return]]



_event
======

.. function:: _event($signal, [$event = false, [$ttl = false]])


    Loads an event for the current signal.

    :param int|string|object $signal: 
    :param object $event: \XPSPL\Event
    :param int|null $ttl: Event TTL

    :rtype: object \XPSPL\Event



_event_exit
===========

.. function:: _event_exit($event)


    Exits the event from the processor.

    :param object $event: \XPSPL\Event



emit
====

.. function:: emit($signal, [$event = false, [$ttl = false]])


    Emits a signal.

    :param mixed $signal: Signal instance or signal.
    :param object $event: \XPSPL\Event

    :rtype: object Event



string(5) "$node"
_execute
========

.. function:: _execute($signal, $queue, $event, [$interrupt = true])


    Executes a queue.
    
    This will monitor the event status and break on a HALT or ERROR state.
    
    Executes interruption functions before and after queue execution.

    :param object $signal: Signal instance.
    :param object $queue: Queue instance.
    :param object $event: Event instance.
    :param boolean $interupt: Run the interrupt functions.

    :rtype: void 



_queue_execute
==============

.. function:: _queue_execute($queue, $event)


    Executes a queue.
    
    If XPSPL_EXHAUSTION_PURGE is true handles will be purged once they 
    reach exhaustion.

    :param object $queue: XPSPL\Queue
    :param object $event: XPSPL\Event

    :rtype: void 



_func_exec
==========

.. function:: _func_exec($function, $event)


    Executes a callable processor function.

    :param callable $function: Function to execute
    :param object $event: Event context to execute within

    :rtype: boolean 



signal_history
==============

.. function:: signal_history()


    Retrieves the signal history.

    :rtype: array 



shutdown
========

.. function:: shutdown()


    Sends the processor the shutdown signal.

    :rtype: void 



event_analysis
==============

.. function:: event_analysis()


    Returns a json encoded array of the event history.

    :rtype: string 



before
======

.. function:: before($signal, $handle)


    Registers a function to interrupt the signal stack before a signal fires,
    allowing for manipulation of the event beore it is passed to handles.

    :param string|object $signal: Signal instance or class name
    :param object $handle: Handle to execute

    :rtype: boolean True|False false is failure



after
=====

.. function:: after($signal, $handle)


    Registers a function to interrupt the signal stack after a signal fires,
    allowing for manipulation of the event after it is passed to handles.

    :param string|object $signal: Signal instance or class name
    :param object $handle: Handle to execute

    :rtype: boolean True|False false is failure



_signal_interrupt
=================

.. function:: _signal_interrupt($signal, $handle, [$interrupt = false])


    Registers a function to interrupt the signal stack before or after a 
    signal fires.

    :param string|object $signal: 
    :param object $handle: Handle to execute
    :param int|null $place: Interuption location. INTERUPT_PRE|INTERUPT_POST

    :rtype: boolean True|False false is failure



_interrupt
==========

.. function:: _interrupt($signal, $type, $event)


    Handle signal interuption functions.

    :param object $signal: Signal
    :param int $interupt: Interupt type

    :rtype: boolean 



clean
=====

.. function:: clean([$history = false])


    Cleans any exhausted signals from the processor.

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



string(7) "$_event"
save_signal_history
===================

.. function:: save_signal_history($flag)


    Sets the flag for storing the event history.
    
    Note that this will delete the current if reset.

    :param boolean $flag: 

    :rtype: void 



current_signal
==============

.. function:: current_signal([$offset = 1])


    Returns the current signal in execution.

    :param integer $offset: In memory hierarchy offset +/-.

    :rtype: object 



current_event
=============

.. function:: current_event([$offset = false])


    Returns the current event.

    :param integer $offset: In memory hierarchy offset +/-.

    :rtype: object \XPSPL\Event





Constants
---------

HASH_STORAGE
============

Storage container node indices

COMPLEX_STORAGE
===============

INTERRUPT_STORAGE
=================

INTERRUPT_PRE
=============

Interuption Types

INTERRUPT_POST
==============

