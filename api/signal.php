<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Register a process function to execute when a signal is emitted.
 *
 * .. note::
 *
 *    All functions unless otherwise specified have a default exhaust of 1
 *    meaning they will execute only one time.
 *
 * .. note::
 *
 *    Functions installed to the same signal execute in FIFO order
 *    when no priority is defined.
 *
 * @param  object  $signal  Signal to install process on.
 * @param  object  $callable  PHP Callable
 *
 * @return  object | boolean - \XPSPL\Process otherwise boolean on error
 *
 * .. note::
 *
 *    Beginning in XPSPL v4.0.0 all signals were converted to strictly objects.
 *
 *    To use a string or integer as a signal it must be wrapped in a ``XP_SIG``.
 *
 * .. warning::
 *
 *    Any signal created using ```XP_SIG``` CANNOT be unique.
 *
 * @example
 *
 * Basic Usage
 *
 * Basic Usage example.
 *
 * .. code-block:: php
 *
 *     <?php
 *     // install a process fuction for foo
 *     xp_signal(XP_SIG('foo'), function(){
 *         echo 'foo';
 *     });
 *     // emit foo
 *     xp_emit(XP_SIG('foo'));
 *     // results
 *     // foo
 */
function xp_signal(\XPSPL\SIG $signal, $process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process);
    }
    return XPSPL::instance()->signal($signal, $process);
}