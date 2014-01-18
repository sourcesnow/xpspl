<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Cleans the processor removing exhausted signals and their processes from
 * the processor.
 *
 * Optionally the history of cleanable signals can be erased from the history.
 *
 * @param  boolean  $history  Erase any history of the signals cleaned.
 *
 * @return  void
 */
function xp_clean($history = false)
{
    return XPSPL::instance()->clean($history);
}