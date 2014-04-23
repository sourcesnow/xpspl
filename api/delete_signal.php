<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Delete a signal from the processor.
 *
 * @param  string|object|int  $signal  Signal to delete.
 * @param  boolean  $history  Erase any history of the signal.
 *
 * @return  boolean
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block:: php
 *
 *    <?php
 *    // Install process on signal foo
 *    xp_signal(XP_SIG('foo'), function(){});
 *    // Delete the signal foo
 *    xp_delete_signal(XP_SIG('foo'));
 *    // Emit the signal foo
 *    xp_emit(XP_SIG('foo'));
 */
function xp_delete_signal($signal, $history = false)
{
    return XPSPL::instance()->delete_signal($signal, $history);
}