<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Register a function to execute after the given signal has been emitted.
 *
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Basic Usage
 *
 * Basic usage example demonstrating this functions capabilities.
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
 *    // results when foo is emitted
 *    // fooafter foo
 *
 * @example
 *
 * Prioritizing Functions
 *
 * Like other functions in XPSPL they can be prioritized using the prioritizing 
 * API functions.
 *
 * .. code-block:: php
 *
 *    <?php
 *
 *    xp_signal(XP_SIG('foo'), high_priority(function(){
 *        echo 'FIRST FOO';
 *    }));
 *
 *    xp_signal(XP_SIG('foo'), low_priority(function(){
 *        echo 'LAST FOO';
 *    }));
 *
 *    xp_signal(XP_SIG('foo'), function(){
 *        echo 'STANDARD FOO';
 *    });
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