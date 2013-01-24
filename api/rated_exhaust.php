<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers the given process to have the given exhaust rate.
 *
 * A rated exhaust allows for you to install processes that exhaust at the set 
 * rate rather than 1.
 *
 * This is useful if you have processes where you need them to execute more than 
 * once but only a certain number of times.
 *
 * If you require a null exhaust process use the ``null_exhaust`` function.
 *
 * @param  callable|process  $process  PHP Callable or Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Controlling exahust rate
 *
 * Installs an awake process for every 2 seconds exhausting after 2 emits.
 * 
 * .. code-block:: php
 *
 *    <?php
 *    import('time');
 *    
 *    time\awake(10, rated_exhaust(2, function(){
 *        echo "10 seconds";
 *    }));
 */ 
function rated_exhaust($limit, $process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process, $limit);
        return $process;
    }
    $process->set_exhaust($limit);
    return $process;
}