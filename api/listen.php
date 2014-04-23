<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers a new listener.
 *
 * Listeners are special objects that register each publically available 
 * method as an executing process using the method name.
 *
 * .. note::
 *
 *     Public methods that are declared with a prepended underscore "_" are 
 *     ignored.
 *
 * @param  object  $listener  The object to register.
 *
 * @return  void
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     class My_Listener extends \XPSPL\Listener 
 *     {
 *         // Register a process for the foo signal.
 *         public function foobar($signal) {
 *             echo 'foobar';
 *         }
 *     }
 *
 *     xp_listener(new My_Listener());
 *
 *     xp_emit(XP_SIG('foobar'));
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     foobar
 */
function xp_listen($listener)
{
    return XPSPL::instance()->listen($listener);
}