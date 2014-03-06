<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Allows for performing complex signal processing using callable PHP variables.
 *
 * A ``\Closure`` will be bound into an object context which allows maintaining 
 * variables across emits within ``$this``.
 *
 * .. note::
 *
 *    A ``\Closure`` can remain bound to its original context by passing 
 *    ``rebind_context as ``false``.
 *
 * @param  callable  $function  Callable variable to use for evaluation.
 * @param  boolean  $rebind_context  Rebind the given closures context to this 
 *                                   object.
 *
 * @return  \\XPSPL\\SIG_Complex  Complex signal registered to the processor.
 *
 * @example
 *
 * Example #1 Detecting a wedding.
 *
 * .. code-block:: php
 *
 *     <?php
 *     // Once a bride, groom and bell signals are emitted we emit the wedding.
 *     $wedding = xp_complex_sig(function($signal){
 *         if (!isset($this->reset) || $this->reset) {
 *             $this->reset = false;
 *             $this->bride = false;
 *             $this->groom = false;
 *             $this->bells = false;
 *         }
 *         switch (true) {
 *             case $signal == XP_SIG('groom'):
 *                 $this->groom = true;
 *                 break;
 *             case $signal == XP_SIG('bride'):
 *                 $this->bride = true;
 *                 break;
 *             case $signal == XP_SIG('bells'):
 *                 $this->bells = true;
 *                 break;
 *         }
 *         if ($this->groom && $this->bride && $this->bells) {
 *             $this->reset = true;
 *             return true;
 *         }
 *         return false;
 *     });
 *
 *     xp_signal($wedding, function(){
 *         echo 'A wedding just happened.';
 *     });
 *
 *     xp_emit(XP_SIG('bride'));
 *     xp_emit(XP_SIG('groom'));
 *     xp_emit(XP_SIG('bells'));
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     A wedding just happened.
 *
 * @example
 *
 * Example #2 Detecting a wedding using network recieved signals.
 *
 * .. code-block:: php
 *
 *     <?php
 *     
 *     xp_import('network');
 *
 *     $server = network\server('0.0.0.0', ['port' => 8000]);
 * 
 *     // Once a bride, groom and bell signals are emitted we emit the wedding.
 *     $wedding = xp_complex_sig(function($signal) use ($server){
 *         if (!isset($this->reset) || $this->reset) {
 *             $this->reset = false;
 *             $this->bride = false;
 *             $this->groom = false;
 *             $this->bells = false;
 *         }
 *         // If its not a network signal ignore it ...
 *         if (!$signal instanceof \XPSPL\network\SIG_Base) {
 *             return false;
 *         }
 *         // Find the signal from the input
 *         $sig = XP_SIG($signal->socket->read());
 *         switch (true) {
 *             case $sig == XP_SIG('groom'):
 *                 $this->groom = true;
 *                 break;
 *             case $sig == XP_SIG('bride'):
 *                 $this->bride = true;
 *                 break;
 *             case $sig == XP_SIG('bells'):
 *                 $this->bells = true;
 *                 break;
 *         }
 *         if ($this->groom && $this->bride && $this->bells) {
 *             $this->reset = true;
 *             return true;
 *         }
 *         return false;
 *     });
 *
 *     xp_signal($wedding, function(){
 *         echo 'A wedding just happened.';
 *     });
 */
function xp_complex_sig($function, $rebind_context = true)
{
    return new \XPSPL\SIG\complex\Func($function, $rebind_context);
}