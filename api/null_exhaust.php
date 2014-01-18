<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Nullifies a processes exhaustion rate.
 *
 * This allows for processes to exhaust indefiantly when a signal is emitted.
 *
 * .. note::
 *
 *     Once a process is registered with a null exhaust it will **never**
 *     be purged from the processor.
 *
 * @param  callable|process  $process  PHP Callable or Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Install a null exhaust process.
 *
 * This example installs a null exhaust process which calls an awake signal
 * every 10 seconds creating an interval.
 *
 * .. code-block:: php
 *
 *    <?php
 *    import('time');
 *
 *    time\awake(10, xp_null_exhaust(function(){
 *        echo "10 seconds";
 *    }));
 */
function xp_null_exhaust($process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process, null);
        return $process;
    }
    $process->set_exhaust(null);
    return $process;
}