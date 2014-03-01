<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers a process to execute when the given signal is emitted.
 *
 * .. note::
 *
 *    All processes by default have an exhaust of ``null``.
 *
 * .. note::
 *
 *    Processes installed to the same signal execute in FIFO order
 *    when no priority is defined.
 *
 * @param  object  $signal  Signal to install process on.
 * @param  object  $callable  PHP Callable
 *
 * @return  object | boolean - \XPSPL\Process otherwise boolean on error
 *
 * .. note::
 *
 *    Beginning in XPSPL v4.0.0 all signals were converted to strictly objects.
 *
 *    To use a string or integer as a signal it must be wrapped in a ``XP_SIG``.
 *
 * .. warning::
 *
 *    Any signal created using ```XP_SIG``` CANNOT be unique.
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block:: php
 *
 *     <?php
 *     
 *     // Install a process on the foo signal
 *     xp_signal(XP_SIG('foo'), function(){
 *         echo 'foo';
 *     });
 *     
 *     // Emit the foo signal
 *     xp_emit(XP_SIG('foo'));
 *
 * The above example will output.
 *
 * .. code-block:: php
 * 
 *     foo
 *
 * @example
 *
 * Example #2 Class Signals
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     // Declare a simple signal
 *     class SIG_Basic extends \XPSPL\SIG {}
 *
 *     // Install a process on the SIG_Basic class
 *     xp_signal(new SIG_Basic(), function(){
 *         echo 'foo';
 *     })
 *
 *     xp_emit(new SIG_Basic());
 *
 * The above example will output.
 *
 * .. code-block:: php
 *
 *     foo
 *
 * @example
 *
 * Example #3 Exhausting Processes
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     // Install a process on the foo signal, with an exhaust of 1
 *     xp_signal(XP_SIG('foo', xp_exhaust(1, function(){
 *         echo 'foo';
 *     })));
 *
 *     // Emit the foo signal
 *     xp_emit(XP_SIG('foo'));
 *     xp_emit(XP_SIG('foo'));
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     foo
 *
 * @example
 *
 * Example #4 Unique Signals
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     // Declare a simple unique
 *     class SIG_Foo extends \XPSPL\SIG {
 *         // Set the signal as unique
 *         protected $_unqiue = true;
 *     }
 *
 *     // Create two unique SIG_Foo objects
 *     $sig_foo_1 = new SIG_Foo();
 *     $sig_foo_2 = new SIG_Foo();
 *
 *     // Install a process to each unique signal
 *     xp_signal($sig_foo_1, function(){
 *         echo 'foo';
 *     });
 *
 *     xp_signal($sig_foo_2, function(){
 *         echo 'bar';
 *     })
 *
 *     // Emit each unique signal
 *     xp_emit($sig_foo_1);
 *     xp_emit($sig_foo_2);
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     foobar
 */
function xp_signal(\XPSPL\SIG $signal, $process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process);
    }
    return XPSPL::instance()->signal($signal, $process);
}