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
 * Registers a signal in the engine.
 * 
 * @param  string|integer|object  $signal  Signal
 *
 * @return  object  Queue
 */
function register($signal)
{
    return \prggmr::instance()->register($signal);
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
 * Load a module.
 * 
 * @param  string  $name  Module name.
 * @param  string|null  $dir  Location of the module. 
 * 
 * @return  void
 */
function load_module($name, $dir = null) 
{
    return \prggmr::instance()->load_module($name, $dir);
}

/**
 * Registers a function to interrupt the signal stack before a signal fires,
 * allowing for manipulation of the event before it is passed to handles.
 *
 * @param  string|object  $signal  Signal instance or class name
 * @param  object  $handle  Handle to execute
 * 
 * @return  boolean  True|False false is failure
 */
function before($signal, $handle)
{
    return \prggmr::instance()->before($signal, $handle);
}

/**
 * Registers a function to interrupt the signal stack after a signal fires.
 * allowing for manipulation of the event after it is passed to handles.
 *
 * @param  string|object  $signal  Signal instance or class name
 * @param  object  $handle  Handle to execute
 * 
 * @return  boolean  True|False false is failure
 */
function after($signal, $handle)
{
    return \prggmr::instance()->after($signal, $handle);
}

/**
 * Returns the prggmr engine.
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

/**
 * Performs a inclusion of the entire directory content, including 
 * subdirectories, with the option to start a listener once the file has been 
 * included.
 *
 * @param  string  $dir  Directory to include.
 * @param  boolean  $listen  Start listeners.
 * @param  string  $path  Path to ignore when starting listeners.
 *
 * @return  void
 */
function dir_include($dir, $listen = false, $path = null)
{
    /**
     * This is some pretty narly code but so far the fastest I have been able 
     * to get this to run.
     */
    $iterator = new \RegexIterator(
        new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir)
        ), '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH
    );
    var_dump($iterator);
    foreach ($iterator as $_file) {
        array_map(function($i) use ($path, $listen){
            include $i;
            if (!$listen) {
                return false;
            }
            if (WINDOWS) {
                $x = '\\';
            } else {
                $x = '/';
            }
            $data = explode($x, str_replace([$path, '.php'], '', $i));
            $class = array_pop($data);
            $namespace = implode('\\', $data);
            $handle = $namespace.'\\'.ucfirst($class);
            if (class_exists($handle, false) && 
                is_subclass_of($handle, '\prggmr\Listener')) {
                listen(new $handle());
            }
        }, $_file);
    }
}

/**
 * Returns the current signal in execution.
 *
 * @param  integer  $offset  In memory hierarchy offset +/-.
 *
 * @return  object
 */
function current_signal($offset = 0)
{
    return \prggmr::instance()->current_signal($offset);
}

/**
 * Returns the current event in execution.
 *
 * @param  integer  $offset  In memory hierarchy offset +/-.
 *
 * @return  object
 */
function current_event($offset = 0)
{
    return \prggmr::instance()->current_event($offset);
}

/**
 * Call the provided function on engine shutdown.
 * 
 * @param  callable|object  $function  Function or handle object
 * 
 * @return  object  \prggmr\Handle
 */
function on_shutdown($function)
{
    return \prggmr\handle(new \prggmr\engine\signal\Loop_Shutdown(), $function);
}

/**
 * Call the provided function on engine start.
 * 
 * @param  callable|object  $function  Function or handle object
 * 
 * @return  object  \prggmr\Handle
 */
function on_start($function)
{
    return \prggmr\handle(new \prggmr\engine\signal\Loop_Start(), $function);
}