<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Returns an installed signal database or null if it cannot be found.
 *
 * @param  object  $signal  SIG
 *
 * @return  null|object  \XPSPL\database\Signals
 */
function xp_get_signal($signal)
{
    if (!$signal instanceof \XPSPL\SIG) {
        $signal = new \XPSPL\SIG();
    }
    return XPSPL::instance()->find_signal_database($signal);
}