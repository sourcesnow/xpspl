<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers the given process to have a high priority.
 *
 * Processes registered with a high priority will be executed before those with
 * a low or default priority.
 *
 * This will register the priority as *0*.
 *
 * .. note::
 *
 *    Interruptions defined to execute before the signal will still be executed
 *    before high priority processes.
 *
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Basic Usage
 *
 * Basic usage example demonstrating high priority processes.
 *
 * .. code-block:: php
 *
 *    <?php
 *
 *    xp_signal(XP_SIG('foo'), function(){
 *        echo 'bar';
 *    });
 *
 *    xp_signal(XP_SIG('foo'), XP_high_priority(function(){
 *        echo 'foo';
 *    }));
 *
 *    // results when foo is emitted
 *    // foobar
 */
function xp_high_priority($process)
{
    return xp_priority(0, $process);
}