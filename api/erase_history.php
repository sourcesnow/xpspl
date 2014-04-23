<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Erases the entire signal history.
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
 *     // Create some history
 *     xp_signal(XP_SIG('foo'), function(){});
 *     for ($i=0;$i<10;$i++) {
 *         xp_emit(XP_SIG('foo'));
 *     }
 *     
 *     // Dump the history count
 *     var_dump(count(xp_signal_history()));
 *
 *     // Erase the history
 *     xp_erase_history();
 *
 *     var_dump(count(xp_signal_history()));
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     10 ... 0
 */
function xp_erase_history()
{
    return XPSPL::instance()->erase_history();
}