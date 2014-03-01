.. /emit.php generated using docpx v1.0.0 on 02/28/14 07:47pm


xp_emit
*******


.. function:: xp_emit($signal, [$context = false])


    Emits a signal.
    
    This will execute all processes and interruptions installed to the signal.
    
    The executed ``SIG`` object is returned.
    
    .. note::
    
       When emitting unique signals, e.g.. complex, routines or defined uniques
       the unique sig object installed must be given.
    
    Once a signal is emitted the following execution chain takes place.
    
    1. Before process interruptions
    2. Installed processes
    3. After process interruptions

    :param signal: Signal to emit.
    :param object: Signal context.

    :rtype: object \XPSPL\SIG


Basic Usage
###########

Basic Usage example.

.. code-block:: php

   <?php
   // Create a unique Foo signal.
   class Foo extends \XPSPL\SIG {
       // declare it as unique
       protected $_unique = true;
   }
   // Install a null exhaust process for the Foo signal
   $foo = new Foo();
   signal($foo, xp_null_exhaust(function(){
       echo "Foo";
   }));
   // Emit foo and new Foo
   xp_emit($foo);
   xp_emit(new Foo());
   // Results
   // Foo





