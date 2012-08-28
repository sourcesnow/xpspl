<?php
namespace prggmr;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Creates a new signal handler.
 *
 * @param  string|integer|object  $signal  Signal to attach the handle.
 * @param  object  $callable  Callable
 *
 * @return  object|boolean  Handle, boolean if error
 */
function handle($signal, $callable)
{
    return \prggmr::instance()->handle($signal, $callable);
}

/**
 * Remove a sig handler.
 *
 * @param  string|integer|object  $signal  Signal handle is attached to.
 * @param  object  $handle  Handle instance.
 *
 * @return  void
 */
function handle_remove($signal, $handle)
{
    return \prggmr::instance()->handle_remove($signal, $handle);   
}

/**
 * Signals an event.
 *
 * @param  string|integer|object  $signal  Signal or a signal instance.
 * @param  array  $vars  Array of variables to pass the handles.
 * @param  object  $event  Event
 *
 * @return  object  \prggmr\Event
 */
function signal($signal, $event = null)
{
    return \prggmr::instance()->signal($signal, $event);
}

/**
 * Returns the event history.
 * 
 * @return  array
 */
function event_history(/* ... */)
{
    return \prggmr::instance()->event_history();
}

/**
 * Registers or returns a signal Queue in storage.
 * 
 * @param  string|integer|object  $signal  Signal
 * @param  boolean  $create  Create the queue if not found.
 *
 * @return  boolean|array  False|[QUEUE_NEW|QUEUE_EMPTY|QUEUE_NONEMPTY, queue, signal]
 */
function register($signal, $create = true)
{
    return \prggmr::instance()->register($signal, $create);
}

/**
 * Searches for a signal in storage returning its storage node if found,
 * optionally the index can be returned.
 * 
 * @param  string|int|object  $signal  Signal to search for.
 * @param  boolean  $index  Return the index of the signal.
 * 
 * @return  null|array  [signal, queue]
 */
function search_signals($signal, $index = false) 
{
    return \prggmr::instance()->search_signals($signal, $index);
}

/**
 * Starts the prggmr event loop.
 *
 * @return  void
 */
function loop()
{
    return \prggmr::instance()->loop();
}

/**
 * Sends the loop the shutdown signal.
 *
 * @return  void
 */
function shutdown()
{
    return \prggmr::instance()->shutdown();
}

/**
 * Load a signal library.
 * 
 * @param  string  $name  Signal library name.
 * @param  string|null  $dir  Location of the library. 
 * 
 * @return  void
 */
function load_signal($name, $dir = null) 
{
    return \prggmr::instance()->load_signal($name, $dir);
}

/**
 * Registers a function to interupt the signal stack before or after a 
 * signal fires.
 *
 * @param  string|object  $signal
 * @param  object  $handle  Handle to execute
 * @param  int|null  $place  Interruption location. prggmr\Engine::INTERRUPT_PRE|prggmr\Engine::INTERRUPT_POST
 * @param  boolean  $class  Register the given signal as a class based interruption
 *                          using the class instance.
 * 
 * @return  boolean  True|False false is failure
 */
function signal_interrupt($signal, $handle, $interrupt = null, $class = false) 
{
    return \prggmr::instance()->signal_interrupt($signal, $handle, $interrupt, $class);
}

/**
 * Returns the prggmr object instance.
 * 
 * @return  object  prggmr\Engine
 */
function prggmr()
{
    return \prggmr::instance();
}

/**
 * Cleans any exhausted signal queues from the engine.
 * 
 * @param  boolean  $history  Erase any history of the signals cleaned.
 * 
 * @return  void
 */
function clean($history = false)
{
    return \prggmr::instance()->clean($history);
}

/**
 * Delete a signal from the engine.
 * 
 * @param  string|object|int  $signal  Signal to delete.
 * @param  boolean  $history  Erase any history of the signal.
 * 
 * @return  boolean
 */
function delete_signal($signal, $history = false)
{
    return \prggmr::instance()->delete_signal($storage, $history);
}

/**
 * Erases any history of a signal.
 * 
 * @param  string|object  $signal  Signal to be erased from history.
 * 
 * @return  void
 */
function erase_signal_history($signal)
{
    return \prggmr::instance()->erase_signal_history($signal);
}

/**
 * Initialize the prggmr global engine.
 *
 * @param  boolean  $event_history  Store a history of all events.
 * @param  boolean  $engine_exceptions  Throw an exception when a error 
 *                                      signal is triggered.
 * 
 * @return  object  prggmr\Engine
 */
function init($event_history = true, $engine_exceptions = true)
{
    return \prggmr::init($event_history, $engine_exceptions);
}

/**
 * Disables the exception handler.
 *
 * @param  boolean  $history  Erase any history of exceptions signaled.
 *
 * @return  void
 */
function disable_signaled_exceptions($history = false)
{
    return \prggmr::instance()->disable_signaled_exceptions($history);
}

/**
 * Enables the exception handler.
 *
 * @return  void
 */
function enable_signaled_exceptions()
{
    return \prggmr::instance()->enable_signaled_exceptions();
}

/**
 * Cleans out the entire event history.
 *
 * @return  void
 */
function erase_history()
{
    return \prggmr::instance()->erase_history();
}

/**
 * Sets the flag for storing the event history.
 *
 * @param  boolean  $flag
 *
 * @return  void
 */
function save_event_history($flag)
{
    return \prggmr::instance()->save_event_history($flag);
}

/**
 * Registers a new event listener object in the engine.
 * 
 * @param  object  $listener  The event listening object
 * 
 * @return  void
 */
function listen($listener)
{
    return \prggmr::instance()->listen($listener);
}