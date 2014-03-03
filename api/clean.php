<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Scans and removes non-emittable signals and processes.
 *
 * .. note::
 *
 *    This DOES NOT flush the processor.
 *
 *    A signal is determined to be emittable only if it has installed processes
 *    that have not exhausted.
 *
 * @param  boolean  $history  Erase any history of removed signals.
 *
 * @return  void
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * Basic usage example demonstrating cleaning old signals and processes.
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     xp_signal(XP_SIG('Test'), function(){
 *         echo 'SIG Test';
 *     });
 *
 *     xp_signal(XP_SIG('Test_2'), function(){
 *         echo 'SIG Test 2';
 *     });
 *
 *     xp_emit(XP_SIG('Test'));
 *
 *     xp_clean();
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     SIG Test
 */
function xp_clean($history = false)
{
    return XPSPL::instance()->clean($history);
}