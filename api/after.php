<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Installs the given process to execute after the signal ``$signal`` is emitted.
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
 * Install a interrupt process after foo.
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