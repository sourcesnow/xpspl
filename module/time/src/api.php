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
 * @param  callable  $callable  Callable function.
 * @param  integer  $instruction  The time instruction. Default = Milliseconds
 *
 * @return  array  [signal, handle]
 */
function awake($time, $callable, $instruction = TIME_SECONDS)
{
    $signal = new SIG_Awake($time, $instruction);
    return [$signal, signal($signal, $callable)];
}