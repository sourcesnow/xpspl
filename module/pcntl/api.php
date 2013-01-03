<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers a function to be called on the SIGINT signal. (CTRL-C)
 *
 * @param  callable  $process  Function to be called.
 * @param  object|null  $processor  XPSPL Processor instance to assign the process.
 *
 * @return  array  [signal, process]
 */
function interrupt($process, $processor = null) 
{
    $signal = new pcntl\Interrupt($processor);
    return [\XPSPL\process($signal, $process), $signal];
}

/**
 * Registers a function to be called on the SIGTERM signal.
 *
 * @param  callable  $process  Function to be called.
 * @param  object|null  $processor  XPSPL Processor instance to assign the process.
 *
 * @return  array  [signal, process]
 */
function terminate($process, $processor = null) 
{
    $signal = new pcntl\Terminate($processor);
    return [\XPSPL\process($signal, $process), $signal];
}