<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Defines the number of times a process will execute when a signal is emitted.
 *
 * .. note::
 *
 *     By default all processes have an exhaust rate of null.
 *
 * @param  callable|process  $process  PHP Callable or Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * Defines the given process with an exhaust of 5.
 *
 * .. code-block:: php
 *
 *    <?php
 *
 * 	  // Install a process for the foo signal that will execute up to 5 times.
 *    xp_signal(XP_SIG('foo'), xp_exhaust(5, function(){
 *        echo 'foo';
 *    });
 *
 *    for($i=0;$i<10;$i++){
 *        xp_emit('foo');
 *    }
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     foofoofoofoofoo
 *
 * @example
 *
 * Example #2 Creating a timeout
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     // Import the time module
 *     xp_import('time');
 *
 *     time\awake(10, xp_exhaust(1, function(){
 *         echo 'This will execute only once.';
 *     });
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     This will execute only once.
 */
function xp_exhaust($limit, $process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process, $limit);
        return $process;
    }
    $process->set_exhaust($limit);
    return $process;
}