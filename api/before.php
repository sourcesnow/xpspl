<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Installs the given process execute to before the signal ``$signal`` is emitted.
 *
 * .. note::
 *
 *    Interruptions use the same prioritizing as the Processor.
 *
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Before Interrupt
 *
 * High priority process will always execute first immediately following
 * interruptions.
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
 *    // before foo foo
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