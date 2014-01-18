<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers the given process to have a high priority.
 *
 * Processes registered with a high priority will be executed before those with
 * a low or default priority.
 *
 * This registers the priority as *0*.
 *
 * .. note::
 *
 *    This installs an exhaust of 0.
 *
 *    This is not an interruption.
 *
 *    Before process interrupts will still be executed before a high priority
 *    process.
 *
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Install a process with high priority
 *
 * .. code-block:: php
 *
 *    <?php
 *
 *    signal('foo', function(){
 *        echo 'bar';
 *    });
 *
 *    signal('foo', high_priority(function(){
 *        echo 'foo';
 *    }));
 *
 *    // results when foo is emitted
 *    // foobar
 */
function xp_high_priority($process)
{
    return xp_priority(0, $process);
}