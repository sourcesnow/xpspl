<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Deletes an installed signal process.
 *
 * .. note::
 *
 *    The \\XPSPL\\Process object given must be the same returned or created
 *    when the process was installed.
 *
 * @param  object  $signal  \\XPSPL\\SIG signal to remove process from.
 * @param  object  $process  \\XPSPL\\Process object to remove.
 *
 * @return  void
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block::php
 *
 *    <?php
 *    // Create a new process on the foo SIG.
 *    $process_one = xp_signal(XP_SIG('foo'), function(){
 *        echo 'foo';
 *    });
 *
 *    $process_two = xp_signal(XP_SIG('foo'), function(){
 *        echo 'bar';
 *    });
 *
 *    // Delete process_one using the returned \XPSPL\Process object
 *    xp_delete_process(XP_SIG('foo'), $process_one);
 *
 *    // Emit foo
 *    xp_emit(XP_SIG('foo'));
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *    bar
 */
function xp_delete_process($signal, $process)
{
    return XPSPL::instance()->delete_process($signal, $process);
}