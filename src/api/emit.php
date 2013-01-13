<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Emit a signals executing all processes installed to the signal. 
 * 
 * A ``SIG`` object is returned which is the SIG object passed
 *
 * When a signal is emitted all processes installed will be executed.
 *
 * @param  signal  $signal  Any SIG_Base object string or integer, an invalid
 *                          ``$signal`` throws a 
 * @param  object  $context  Context signal
 *
 * @return  object  SIG
 *
 * @example
 *
 * Emitting a signal.
 *
 * .. code-block:: php
 *
 *    <?php
 *    // Emit the foo signal
 *    emit('foo');
 */
function emit($signal, $context = null)
{
    global $XPSPL;
    return $XPSPL->emit($signal, $context);
}