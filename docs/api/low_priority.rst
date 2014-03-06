.. /low_priority.php generated using docpx v1.0.0 on 03/06/14 11:19am


xp_low_priority
***************


.. function:: xp_low_priority($process)


    Sets a function to have a low priority
    
    Processes registered with a low priority will be executed after those with
    a high and default priority.
    
    .. note::
    
       This registers the priority as *PHP_INT_MAX*.
    
       This is not an interruption.
    
       After signal interrupts will still be executed after a low priority
       process.

    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Using low priority processes
############################

Low priority processes always execute last.

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), function(){
       echo 'foo';
   });

   xp_signal(XP_SIG('foo'), low_priority(function(){
       echo 'bar';
   }));

   xp_emit(XP_SIG('foo'));

   // results when foo is emitted
   // foobar




Created on 03/06/14 11:19am using `Docpx <http://github.com/prggmr/docpx>`_