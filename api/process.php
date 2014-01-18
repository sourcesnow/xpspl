<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Generates a \XPSPL\Process object from the given PHP callable.
 *
 * .. note::
 *
 *    See the ``priority`` and ``exhaust`` functions for setting the priority
 *    and exhaust of the created process.
 *
 * @param  callable  $callable
 *
 * @return  void
 *
 * @example
 *
 * Creates a new XPSPL Process object.
 *
 * .. code-block::php
 *
 *    <?php
 *
 *    $process = xp_process(function(){});
 *
 *    xp_signal(XP_SIG('foo'), $process);
 *
 */
function xp_process($callable)
{
    return new \XPSPL\Process($callable);
}