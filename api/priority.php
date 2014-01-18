<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Sets the priority of a process.
 *
 * This allows for controlling the order of processes rather than using FIFO.
 *
 * Priority uses an ascending order where 0 > 1.
 *
 * Processes registered with a high priority will be executed before those with
 * a low or default priority.
 *
 * Process priority is handy when multiple process will execute and their order
 * is important.
 *
 * .. note::
 *
 *    This is different from an interrupt.
 *
 *    Installed interrupts will still be executed before or after a
 *    prioritized process.
 *
 * @param  integer  $priority  Priority to assign
 *
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Installing multiple priorities
 *
 * This installs multiple process each with a seperate ascending priority.
 *
 * .. code-block:: php
 *
 *    <?php
 *
 *    xp_signal(XP_SIG('foo'), priority(0, function(){
 *        echo 'foo';
 *    }));
 *
 *    xp_signal(XP_SIG('foo'), priority(3, function(){
 *        echo 'bar';
 *    }));
 *
 *    xp_signal(XP_SIG('foo'), priority(5, function(){
 *        echo 'hello';
 *    }));
 *
 *    xp_signal(XP_SIG('foo'), priority(10, function(){
 *        echo 'world';
 *    }));
 *
 *    // results when foo is emitted
 *    // foobarhelloworld
 */
function xp_priority($priority, $process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process);
    }
    $process->set_priority($priority);
    return $process;
}