.. /exhaust.php generated using docpx v1.0.0 on 03/02/14 12:15pm


xp_exhaust
**********


.. function:: xp_exhaust($limit, $process)


    Defines the number of times a process will execute when a signal is emitted.
    
    If you require a null exhaust process use the ``xp_null_exhaust`` function.
    
    .. note::
    
        By default all processes have an exhaust rate of 1.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Exhaust usage
#############

Defines the given process with an exhaust of 5.

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), xp_exhaust(5, function(){
       echo 'foo';
   });

   for($i=0;$i<5;$i++){
       xp_emit('foo');
   }

   // results
   // foofoofoofoofoo





