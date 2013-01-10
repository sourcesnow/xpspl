.. /signal.php generated using docpx on 01/10/13 09:38pm
signal
------

.. function:: signal()


    Installs a process to execute when the given signal is emitted.
    
    .. note::
    
       All processes unless otherwise specified have a default exhaust of 1 and 
       execute in FIFO order.

    :param string|integer|object $signal: Signal to attach the process.
    :param object $callable: Callable

    :rtype: object|boolean Process, boolean if error


Example
+++++++
 
Install a process for the string signal 'foo'.

.. code-block:: php

    <?php

    signal('foo', function(){
        echo 'foo was just emitted';
    });

Example
+++++++
 
Install a process for the XPSPL startup object signal.

.. code-block:: php

    <?php

    signal(new \XPSPL\processor\SIG_Startup(), function(){
        echo "I NEVER EXHAUST!!";
    });

Example
+++++++
 
Install a process for the integer signal 1.

.. code-block:: php

    <?php

    signal(1, function(){
        echo "I NEVER EXHAUST!!";
    });

Example
+++++++
 
Install a process that will never exhaust.

.. code-block:: php

   <?php

   signal('foo', null_exhaust(function(){
       echo "Foo emitted";
   }));



