<?php
namespace prggmr\signal\pcntl;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers a function to be called on the SIGINT signal. (CTRL-C)
 *
 * @param  callable  $handle  Function to be called.
 * @param  object|null  $engine  prggmr Engine instance to assign the handle.
 *
 * @return  array  [signal, handle]
 */
function interrupt($handle, $engine = null) 
{
    $signal = new Interrupt($engine);
    return [\prggmr\handle($signal, $handle), $signal];
}