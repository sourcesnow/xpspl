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
 * @param  callable  $handle  Function to be called.
 * @param  object|null  $processor  XPSPL Processor instance to assign the handle.
 *
 * @return  array  [signal, handle]
 */
function interrupt($handle, $processor = null) 
{
    $signal = new pcntl\Interrupt($processor);
    return [\XPSPL\handle($signal, $handle), $signal];
}

/**
 * Registers a function to be called on the SIGTERM signal.
 *
 * @param  callable  $handle  Function to be called.
 * @param  object|null  $processor  XPSPL Processor instance to assign the handle.
 *
 * @return  array  [signal, handle]
 */
function terminate($handle, $processor = null) 
{
    $signal = new pcntl\Terminate($processor);
    return [\XPSPL\handle($signal, $handle), $signal];
}