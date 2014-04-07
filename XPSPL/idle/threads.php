<?php
namespace XPSPL\idle;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\Processor as Processor;

/**
 * Idles the processor checking if registered processor threads are alive.
 *
 * Threaded extends and replaces the Time idle in the processor once threaded
 * processes are registered.
 */
class Threads extends Time
{
    /**
     * Run the idle function.
     */
    public function idle(Processor $processor)
    {
        foreach ($processor->active_threads as $_key => $_thread) {
            echo 'I RAN';
            // Add better checks
            if ($_thread->isRunning() === false) {
                unset($process->active_threads[$_key]);
            }
        }
        parent::idle($processor);
    }
}
