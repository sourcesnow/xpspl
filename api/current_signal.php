<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Returns the current signal in execution.
 *
 * A negative offset can be provided to walk backwards through a signal stack
 * during child execution.
 *
 * @param  integer  $offset  In memory hierarchy offset +/-.
 *
 * @return  object
 *
 * @example
 *
 * Get the current signal.
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
 *     // Results in 'foo'
 *
 * @example
 *
 * Parent signals
 *
 * Providing a negative offset allows for fetching the parent signal for the
 * currently executing signal.
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     xp_signal(XP_SIG('bar'), function(){
 *         xp_emit(XP_SIG('foo'));
 *     });
 *
 *     xp_signal(XP_SIG('foo'), function(){
 *         $a = xp_current_signal(-1);
 *         echo $a->get_index();
 *     });
 *
 *     // Results in 'bar'
 */
function xp_current_signal($offset = 0)
{
    return XPSPL::instance()->current_signal($offset);
}