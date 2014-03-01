.. /high_priority.php generated using docpx v1.0.0 on 02/28/14 07:47pm


xp_high_priority
****************


.. function:: xp_high_priority($process)


    Registers the given process to have a high priority.
    
    Processes registered with a high priority will be executed before those with
    a low or default priority.
    
    This will register the priority as *0*.
    
    .. note::
    
       Interruptions defined to execute before the signal will still be executed
       before high priority processes.

    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Basic Usage
###########

Basic usage example demonstrating high priority processes.

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), function(){
       echo 'bar';
   });

   xp_signal(XP_SIG('foo'), XP_high_priority(function(){
       echo 'foo';
   }));

   // results when foo is emitted
   // foobar





