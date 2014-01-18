<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Generates an XPSPL SIG object from the given ``$signal``.
 *
 * This function is only a shorthand for ``new SIG($signal)``.
 *
 * @param  string|  $signal  Signal process is attached to.
 *
 * @return  object  \XPSPL\SIG
 *
 * @example
 *
 * Creating a SIG.
 *
 * This will create a SIG idenitified by 'foo'.
 *
 * .. code-block:: php
 *
 *    <?php
 *    xp_signal(XP_SIG('foo'), function(){
 *        echo "HelloWorld";
 *    });
 *
 *    xp_emit(XP_SIG('foo'));
 */
function XP_SIG($signal)
{
    return new \XPSPL\SIG($signal);
}