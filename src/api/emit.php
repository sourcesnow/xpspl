<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Emit a signal, returning the resulting ``SIG`` object.
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