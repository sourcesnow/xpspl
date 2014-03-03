<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Execute a function after a signal has been emitted.
 *
 * @param  object  $signal  \XPSPL\SIG
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block:: php
 *
 *    <?php
 *
 *    xp_signal(XP_SIG('foo'), function(){
 *        echo 'foo';
 *    });
 *
 *    xp_after(XP_SIG('foo'), function(){
 *        echo 'after foo';
 *    });
 *
 * The above code will output.
 *
 * .. code-block:: php
 * 
 *    // fooafter foo
 */
function xp_after($signal, $process)
{
    if (!$signal instanceof \XPSPL\SIG) {
        $signal = new \XPSPL\SIG($signal);
    }
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process);
    }
    return XPSPL::instance()->after($signal, $process);
}