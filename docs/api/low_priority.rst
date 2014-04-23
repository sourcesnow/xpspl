.. /low_priority.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_low_priority
***************


.. function:: xp_low_priority($process)


    Creates or sets a process to have a low priority.
    
    Processes with a low priority will be executed after those with a high 
    priority.
    
    .. note::
    
       This registers the priority as *PHP_INT_MAX*.
    
       This is not an interruption.
    
       After signal interrupts will still be executed after a low priority
       process.

    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Example #1 Basic Usage
######################

Low priority processes always execute last.

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), xp_low_priority(function(){
       echo 'bar';
   }));

   xp_signal(XP_SIG('foo'), function(){
       echo 'foo';
   });

   xp_emit(XP_SIG('foo'));

The above code will output.

.. code-block:: php

   foobar





