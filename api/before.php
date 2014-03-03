<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Execute a function before a signal is emitted.
 *
 * @param  object  $signal  \\XPSPL\\SIG
 * @param  callable|process  $process  PHP Callable or \\XPSPL\\Process.
 *
 * @return  object  \\XPSPL\\Process
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
 *    xp_before(XP_SIG('foo'), function(){
 *        echo 'before foo';
 *    });
 *
 *    // results when foo is emitted
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *    // before foo foo
 *
 * @example
 *
 * Example #2 Class Signals
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     class SIG_Foo extends \XPSPL\SIG {}
 *
 *     xp_signal(new SIG_Foo(), function(){
 *         echo 'bar';
 *     });
 *
 *     xp_before(new SIG_Foo(), function(){
 *         echo 'foo';
 *     });
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     foobar
 */
function xp_before($signal, $process)
{
    if (!$signal instanceof \XPSPL\SIG) {
        $signal = new \XPSPL\SIG($signal);
    }
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process);
    }
    return XPSPL::instance()->before($signal, $process);
}