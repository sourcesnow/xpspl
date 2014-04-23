<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Creates or sets a process to have a low priority.
 *
 * Processes with a low priority will be executed after those with a high 
 * priority.
 *
 * .. note::
 *
 *    This registers the priority as *PHP_INT_MAX*.
 *
 *    This is not an interruption.
 *
 *    After signal interrupts will still be executed after a low priority
 *    process.
 *
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * Low priority processes always execute last.
 *
 * .. code-block:: php
 *
 *    <?php
 *
 *    xp_signal(XP_SIG('foo'), xp_low_priority(function(){
 *        echo 'bar';
 *    }));
 * 
 *    xp_signal(XP_SIG('foo'), function(){
 *        echo 'foo';
 *    });
 *
 *    xp_emit(XP_SIG('foo'));
 *
 * The above code will output.
 * 
 * .. code-block:: php
 * 
 *    foobar
 */
function xp_low_priority($process)
{
    return xp_priority(PHP_INT_MAX, $process);
}