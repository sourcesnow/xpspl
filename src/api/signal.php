<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Installs a process to execute when the given signal is emitted.
 *
 * .. note::
 * 
 *    All processes unless otherwise specified have a default exhaust of 1 and 
 *    execute in FIFO order.
 *
 * @param  string|integer|object  $signal  Signal to attach the process.
 * @param  object  $callable  Callable
 *
 * @return  object|boolean  Process, boolean if error
 *
 * @example
 *
 * Install a process for the string signal 'foo'.
 *
 * .. code-block:: php
 * 
 *     <?php
 * 
 *     signal('foo', function(){
 *         echo 'foo was just emitted';
 *     });
 *
 * @example
 *
 * Install a process for the XPSPL startup object signal.
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     signal(new \XPSPL\processor\SIG_Startup(), function(){
 *         echo "I NEVER EXHAUST!!";
 *     });
 *
 * @example
 *
 * Install a process for the integer signal 1.
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     signal(1, function(){
 *         echo "I NEVER EXHAUST!!";
 *     });
 *
 * @example
 *
 * Install a process that will never exhaust.
 *
 * .. code-block:: php
 *
 *    <?php
 *
 *    signal('foo', null_exhaust(function(){
 *        echo "Foo emitted";
 *    }));
 */
function signal($signal, $callable)
{
    global $XPSPL;
    return $XPSPL->signal($signal, $callable);
}