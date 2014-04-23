.. /high_priority.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_high_priority
****************


.. function:: xp_high_priority($process)


    Creates or sets a process to have a high priority.
    
    Processes with a high priority will be executed before those with
    a low or default priority.
    
    This will register the priority as *0* as priority goes in ascending order.
    
    .. note::
    
       Interruptions will be executed before high priority processes.

    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Example #1 Basic Usage
######################

Basic usage example demonstrating high priority processes.

.. code-block:: php

   <?php

   // Register a process on the foo signal
   xp_signal(XP_SIG('foo'), function(){
       echo 'bar';
   });

   // Register another process with high priority
   xp_signal(XP_SIG('foo'), xp_high_priority(function(){
       echo 'foo';
   }));

The above code will output.

.. code-block:: php

   foobar





