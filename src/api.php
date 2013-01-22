<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Returns the signal history.
 * 
 * @return  array
 */
function signal_history(/* ... */)
{
    global $XPSPL;
    return $XPSPL->signal_history();
}

/**
 * Registers a signal in the processor.
 * 
 * @param  string|integer|object  $signal  Signal
 *
 * @return  object  Queue
 */
function register_signal($signal)
{
    global $XPSPL;
    return $XPSPL->register_signal($signal);
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
    global $XPSPL;
    return $XPSPL->search_signals($signal, $index);
}

/**
 * Starts the XPSPL wait loop.
 *
 * @return  void
 */
function wait_loop()
{
    global $XPSPL;
    return $XPSPL->wait_loop();
}

/**
 * Sends the loop the shutdown signal.
 *
 * @return  void
 */
function shutdown()
{
    global $XPSPL;
    return $XPSPL->shutdown();
}

/**
 * Import a module.
 * 
 * @param  string  $name  Module name.
 * @param  string|null  $dir  Location of the module. 
 * 
 * @return  void
 */
function import($name, $dir = null) 
{
    return \XPSPL\Library::instance()->load($name, $dir);
}

/**
 * Registers a function to interrupt the signal stack before a signal fires,
 * allowing for manipulation of the event before it is passed to processs.
 *
 * @param  string|object  $signal  Signal instance or class name
 * @param  object  $process  Process to execute
 * 
 * @return  boolean  True|False false is failure
 */
function before($signal, $process)
{
    global $XPSPL;
    return $XPSPL->before($signal, $process);
}

/**
 * Registers a function to interrupt the signal stack after a signal fires.
 * allowing for manipulation of the event after it is passed to processs.
 *
 * @param  string|object  $signal  Signal instance or class name
 * @param  object  $process  Process to execute
 * 
 * @return  boolean  True|False false is failure
 */
function after($signal, $process)
{
    global $XPSPL;
    return $XPSPL->after($signal, $process);
}

/**
 * Returns the XPSPL processor.
 * 
 * @return  object  XPSPL\Processor
 */
function XPSPL()
{
    global $XPSPL;
    return $XPSPL;
}

/**
 * Cleans any exhausted signal queues from the processor.
 * 
 * @param  boolean  $history  Erase any history of the signals cleaned.
 * 
 * @return  void
 */
function clean($history = false)
{
    global $XPSPL;
    return $XPSPL->clean($history);
}

/**
 * Delete a signal from the processor.
 * 
 * @param  string|object|int  $signal  Signal to delete.
 * @param  boolean  $history  Erase any history of the signal.
 * 
 * @return  boolean
 */
function delete_signal($signal, $history = false)
{
    global $XPSPL;
    return $XPSPL->delete_signal($storage, $history);
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
    global $XPSPL;
    return $XPSPL->erase_signal_history($signal);
}

/**
 * Disables the exception process.
 *
 * @param  boolean  $history  Erase any history of exceptions signaled.
 *
 * @return  void
 */
function disable_signaled_exceptions($history = false)
{
    global $XPSPL;
    return $XPSPL->disable_signaled_exceptions($history);
}

/**
 * Cleans out the entire event history.
 *
 * @return  void
 */
function erase_history()
{
    global $XPSPL;
    return $XPSPL->erase_history();
}

/**
 * Sets the flag for storing the event history.
 *
 * @param  boolean  $flag
 *
 * @return  void
 */
function set_signal_history($flag)
{
    global $XPSPL;
    return $XPSPL->set_signal_history($flag);
}

/**
 * Registers a new event listener object in the processor.
 * 
 * @param  object  $listener  The event listening object
 * 
 * @return  void
 */
function listen($listener)
{
    global $XPSPL;
    return $XPSPL->listen($listener);
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
            $process = $namespace.'\\'.ucfirst($class);
            if (class_exists($process, false) && 
                is_subclass_of($process, '\XPSPL\Listener')) {
                listen(new $process());
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
    global $XPSPL;
    return $XPSPL->current_signal($offset);
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
    global $XPSPL;
    return $XPSPL->current_event($offset);
}

/**
 * Call the provided function on processor shutdown.
 * 
 * @param  callable|object  $function  Function or process object
 * 
 * @return  object  \XPSPL\Process
 */
function on_shutdown($function)
{
    return signal(new \XPSPL\processor\SIG_Shutdown(), $function);
}

/**
 * Call the provided function on processor start.
 * 
 * @param  callable|object  $function  Function or process object
 * 
 * @return  object  \XPSPL\Process
 */
function on_start($function)
{
    return signal(new \XPSPL\processor\SIG_Startup(), $function);
}

/**
 * Empties the storage, history and clears the current state.
 *
 * @return void
 */
function XPSPL_flush(/* ... */)
{
    global $XPSPL;
    return $XPSPL->flush();
}