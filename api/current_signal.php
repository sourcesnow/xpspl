<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Retrieve the current signal in execution.
 *
 * @param  integer  $offset  If a positive offset is given it will return from
 *                           the top of the signal stack, if negative it will
 *                           return from the bottom (current) of the stack.
 *
 * @return  object  \\XPSPL\\SIG
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     xp_signal(XP_SIG('foo'), function(\XPSPL\SIG $signal){
 *         $a = xp_current_signal();
 *         echo $a->get_index();
 *     });
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *    foo
 *
 * @example
 *
 * Example #2 Parent Signals
 *
 * Parent signals can be fetched by using a negative offset ``< -1``.
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     // Install a process on the bar SIG
 *     xp_signal(XP_SIG('bar'), function(){
 *         // Emit foo within bar
 *         xp_emit(XP_SIG('foo'));
 *     });
 *
 *     // Install a process on the foo SIG
 *     xp_signal(XP_SIG('foo'), function(){
 *         // Get the parent of foo
 *         $a = xp_current_signal(-2);
 *         echo $a->get_index();
 *     });
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *    bar
 */
function xp_current_signal($offset = 0)
{
    return XPSPL::instance()->current_signal($offset);
}