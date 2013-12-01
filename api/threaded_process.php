<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Makes a new or current process threaded.
 *
 * @param  boolean  $flag
 *
 * @return  void
 */
function threaded_process($process)
{
	if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process);
    }
    $process->enable_threads();
    return $process;
}