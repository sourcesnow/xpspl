.. /priority.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_priority
***********


.. function:: xp_priority($priority, $process)


    Sets the priority of a process.
    
    This allows for controlling the order of processes rather than using FIFO.
    
    Priority uses an ascending order where 0 > 1.
    
    Processes registered with a high priority will be executed before those with
    a low or default priority.
    
    Process priority is handy when multiple process will execute and their order
    is important.
    
    .. note::
    
       This is different from an interrupt.
    
       Installed interrupts will still be executed before or after a
       prioritized process.

    :param integer: Priority to assign
    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Example #1 Basic Usage
######################

This installs multiple process each with a seperate ascending priority.

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), priority(0, function(){
       echo 'foo';
   }));

   xp_signal(XP_SIG('foo'), priority(3, function(){
       echo 'bar';
   }));

   xp_signal(XP_SIG('foo'), priority(5, function(){
       echo 'hello';
   }));

   xp_signal(XP_SIG('foo'), priority(10, function(){
       echo 'world';
   }));

The above code will output.

.. code-block:: php

   foobarhelloworld





