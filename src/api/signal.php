<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Installs a new signal processor.
 *
 * @param  string|integer|object  $signal  Signal to attach the process.
 * @param  object  $callable  Callable
 *
 * @return  object|boolean  Process, boolean if error
 *
 * @example
 *
 * This example demonstrates how to do something amazing!
 *
 * .. code-block:: php
 * 
 *     <?php
 * 
 *     signal(new SIG_Startup(), function(){
 *         echo 'Doing something on startup';
 *     });
 *
 * @example
 *
 * This demonstrates how to do something even more amazing!
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     signal(new SIG_Shutdown(), null_exhaust(function(){
 *         echo "I NEVER EXHAUST!!";
 *     }))
 *
 * @example
 *
 * This demonstrates how to do something even more amazing!
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     signal(new SIG_AS(), null_exhaust(function(){
 *         echo "I NEVER EXHAUST!!";
 *     }))
 */
function signal($signal, $callable)
{
    global $XPSPL;
    return $XPSPL->signal($signal, $callable);
}