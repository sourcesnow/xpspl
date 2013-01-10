<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers the given process to have a null exhaust.
 *
 * @param  callable|process  $process  PHP Callable or Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Install an awake signal for every 10 seconds.
 * 
 * .. code-block:: php
 *
 *    <?php
 *    import('time');
 *    
 *    time\awake(10, null_exhaust(function(){
 *        echo "10 seconds";
 *    }));
 */
function null_exhaust($process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process, null);
        return $process;
    }
    $process->set_exhaust(null);
    return $process;
}