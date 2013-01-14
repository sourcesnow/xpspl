<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Installs a process to execute when the given signal is emitted.
 *
 * .. note::
 * 
 *    All processes unless otherwise specified have a default exhaust of 1 and 
 *    execute in FIFO order.
 *
 * @param  string|integer|object  $signal  Signal to attach the process.
 * @param  object  $callable  Callable
 *
 * @return  object|boolean  Process, boolean if error
 *
 * @example
 *
 * Object Signals
 *
 * Objects signals are the prefered method of installing and emit signals as it 
 * helps remove user-error, provides easier development, debugging and 
 * refactoring.
 *
 * An object signal can represent both and index and unique signal.
 *
 * In this example an object signal of Foo is created.
 *
 * .. note::
 *
 *    When using object signals that are non-unique always provide a new 
 *    instance of the object.
 *    
 *    The processor is optimized to deal with large amounts of objects and will 
 *    destroy any unessecary instances.
 *
 * .. code-block:: php
 *
 *     <?php
 *     // Create our Foo signal object
 *     class Foo extends \XPSPL\SIG {}
 *     // Install a process for Foo
 *     signal(new Foo(), function(){
 *         echo "Foo";
 *     });
 *     // Emit Foo
 *     emit(new Foo());
 *
 * @example
 *
 * String and Integer signals
 *
 * When using only strings and integers as a signal the string or integer can 
 * be provided directly rather than giving an object.
 *
 * .. note::
 *
 *    String and integer signals are treated as index signals and cannot be 
 *    unique.
 *
 * .. code-block:: php
 * 
 *     <?php
 *     // install a process for foo
 *     signal('foo', function(){
 *         echo 'foo';
 *     });
 *     // emit foo
 *     emit('foo');
 *     // results
 *     // foo
 *
 * @example
 *
 * Null exhaust
 *
 * Install a process for the integer signal 1.
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     signal(1, function(){
 *         echo "I NEVER EXHAUST!!";
 *     });
 */
function signal($signal, $callable)
{
    global $XPSPL;
    return $XPSPL->signal($signal, $callable);
}