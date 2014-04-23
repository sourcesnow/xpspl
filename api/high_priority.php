<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Creates or sets a process to have a high priority.
 *
 * Processes with a high priority will be executed before those with
 * a low or default priority.
 *
 * This will register the priority as *0* as priority goes in ascending order.
 *
 * .. note::
 *
 *    Interruptions will be executed before high priority processes.
 *
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * Basic usage example demonstrating high priority processes.
 *
 * .. code-block:: php
 *
 *    <?php
 *
 *    // Register a process on the foo signal
 *    xp_signal(XP_SIG('foo'), function(){
 *        echo 'bar';
 *    });
 *
 *    // Register another process with high priority
 *    xp_signal(XP_SIG('foo'), xp_high_priority(function(){
 *        echo 'foo';
 *    }));
 *
 * The above code will output.
 *
 * .. code-block:: php
 * 
 *    foobar
 */
function xp_high_priority($process)
{
    return xp_priority(0, $process);
}