.. /signal.php generated using docpx on 02/01/13 10:00pm


Function - signal
*****************


.. function:: signal($signal, $process)


    Installs a process to execute when the given signal is emitted.
    
    .. note::
    
       All processes unless otherwise specified have a default exhaust of 1 and 
       execute in FIFO order.

    :param string|integer|object: Signal to attach the process.
    :param object: Callable

    :rtype: object|boolean Process, boolean if error


Object Signals
##############

Objects signals are the prefered method of installing and emit signals as it 
helps remove user-error, provides easier development, debugging and 
refactoring.

An object signal can represent both and index and unique signal.

In this example an object signal of Foo is created.

.. note::

   When using object signals that are non-unique always provide a new 
   instance of the object.
   
   The processor is optimized to deal with large amounts of objects and will 
   destroy any unessecary instances.

.. code-block:: php

    <?php
    // Create our Foo signal object
    class Foo extends \XPSPL\SIG {}
    // Install a process for Foo
    signal(new Foo(), function(){
        echo "Foo";
    });
    // Emit Foo
    emit(new Foo());

String and Integer signals
##########################

When using only strings and integers as a signal the string or integer can 
be provided directly rather than giving an object.

.. note::

   String and integer signals are treated as index signals and cannot be 
   unique.

.. code-block:: php

    <?php
    // install a process for foo
    signal('foo', function(){
        echo 'foo';
    });
    // emit foo
    emit('foo');
    // results
    // foo

Null exhaust process.
#####################

Install a process that never exhausts.

.. note::

    Once a null exhaust process is installed it must be removed using 
    ``remove_process``.

.. code-block:: php

    <?php

    signal(SIG('foo'), null_exhaust(function(){
        echo "foo";
    }));

    for ($i=0;$i<35;$i++) {
        emit(SIG('foo'));
    }
    // results
    // foo
    // foo
    // foo
    // foo
    // ...




Last updated on 02/01/13 10:00pm