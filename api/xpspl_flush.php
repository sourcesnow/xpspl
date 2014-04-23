<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Performs a complete flush of the processor.
 *
 * This will clear the processor state and remove the following.
 *
 * * Installed signals.
 * * Installed processes.
 * * Signal history.
 *
 * @return void
 */
function XPSPL_flush(/* ... */)
{
    return XPSPL::instance()->flush();
}