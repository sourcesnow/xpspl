<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
namespace time;

/**
 * Wakes the system loop and runs the provided function.
 *
 * @param  integer  $time  Time to wake in.
 * @param  callable  $callback  Callable function.
 * @param  integer  $instruction  The time instruction. Default = Seconds
 *
 * @return  array  [signal, process]
 */
function awake($time, $callback, $instruction = TIME_SECONDS)
{
    if (!$time instanceof SIG_Awake) {
        $time = new SIG_Awake($time, $instruction);
    }
    return xp_signal($time, $callback);
}

/**
 * Wakes the system using the Unix CRON expressions.
 *
 * If no priority is provided with the ```$process``` it is set to null.
 *
 * @param  string  $cron  CRON Expression
 * @param  callable  $process  Callback function to run
 *
 * @return  array [signal, process]
 */
function CRON($cron, $process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = xp_null_exhaust($process);
    }
    $signal = new SIG_CRON($cron);
    return [$signal, xp_signal($signal, $process)];
}