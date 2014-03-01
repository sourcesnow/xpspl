.. /after.php generated using docpx v1.0.0 on 02/28/14 07:47pm


xp_after
********


.. function:: xp_after($signal, $process)


    Execute a function after a signal has been emitted.

    :param object: \XPSPL\SIG
    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Basic Usage
###########

Basic usage example.

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), function(){
       echo 'foo';
   });

   xp_after(XP_SIG('foo'), function(){
       echo 'after foo';
   });

   // results when foo is emitted
   // fooafter foo





