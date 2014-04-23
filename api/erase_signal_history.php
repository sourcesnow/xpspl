<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Erases the history of only the given signal.
 *
 * .. warning::
 *
 *     This will delete the history for *ANY* signals that are a direct child of
 *     the to be deleted signal.
 *
 *     As an example,
 *
 *     When ``sig_foo`` emits it is proceeded directly by ``sig_foo2`` emitting
 *     within the ``sig_foo`` execution.
 *
 *     When sig_foo is deleted the history of sig_foo_child will also be removed.
 *
 * @param  string|object  $signal  Signal to be erased from history.
 *
 * @return  void
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block:: php
 *
 *     <?php
 *     
 *     // Install a procss for the foo and bar signals.
 *     xp_signal(XP_SIG('foo'), function(){});
 *     xp_signal(XP_SIG('bar'), function(){});
 *     // Emit each foo and bar 10 times.
 *     for($i=0;$i<10;$i++) {
 *         xp_emit(XP_SIG('foo'));
 *         xp_emit(XP_SIG('bar'));
 *     }
 *     var_dump(count(xp_signal_history()));
 *     // Delete the history of the foo signal.
 *     xp_delete_signal_history(XP_SIG('foo'));
 *     var_dump(count(xp_signal_history()));
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     20 ... 10
 */
function xp_erase_signal_history($signal)
{
    return XPSPL::instance()->erase_signal_history($signal);
}