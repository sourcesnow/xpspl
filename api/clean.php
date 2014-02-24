<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Removes unexecutable signals and processes from XPSPL.
 *
 * @param  boolean  $history  Erase any history removed signals.
 *
 * @return  void
 */
function xp_clean($history = false)
{
    return XPSPL::instance()->clean($history);
}