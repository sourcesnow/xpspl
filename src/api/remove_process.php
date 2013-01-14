<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Removes an installed signal process.
 *
 * @param  string|integer|object  $signal  Signal process is attached to.
 * @param  object  $process  Process.
 *
 * @return  void
 *
 * @example
 *
 * Removing installed processes
 *
 * Removes the installed process from the foo signal.
 *
 * .. code-block::php
 *
 *    <?php
 *    $process = signal('foo', function(){});
 *    
 *    remove_process('foo', $process);
 */
function remove_process($signal, $process)
{
    global $XPSPL;
    return $XPSPL->remove_process($signal, $process);   
}