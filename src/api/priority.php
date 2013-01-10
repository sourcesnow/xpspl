<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers the given process to have the given priority.
 *
 * Processes registered with a high priority will be executed before those with 
 * a low or default priority.
 *
 * This allows for controlling the order of processes rather than using FIFO.
 *
 * A high priority process is useful when multiple processes will execute and it 
 * must always be one of the very first to run.
 *
 * .. note::
 *
 *    This is not an interruption.
 *    
 *    Installed interruptions will still be executed before a high priority 
 *    process.
 *
 * @param  integer  $priority  Priority to assign
 * 
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Installs a process with high priority.
 *
 * .. code-block:: php
 * 
 *    <?php
 *    
 *    signal('foo', function(){
 *        echo 'bar';
 *    });
 *    
 *    signal('foo', high_priority(function(){
 *        echo 'foo';
 *    }));
 *
 *    // results when foo is emitted
 *    // foobar
 */
function priority($priority, $process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process);
    }
    $process->set_priority($priority);
    return $process;
}