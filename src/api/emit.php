<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Emit a signal.
 *
 * @param  string|integer|object  $signal  Signal
 * @param  object  $context  Context signal
 *
 * @return  object  \XPSPL\Signal
 */
function emit($signal, $context = null)
{
    global $XPSPL;
    return $XPSPL->emit($signal, $context);
}