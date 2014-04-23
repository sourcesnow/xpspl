.. /after.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_after
********


.. function:: xp_after($signal, $process)


    Execute a function after a signal has been emitted.

    :param object: \\XPSPL\\SIG
    :param callable|process: PHP Callable or \\XPSPL\\Process.

    :rtype: object \\XPSPL\\Process


Example #1 Basic Usage
######################

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), function(){
       echo 'foo';
   });

   xp_after(XP_SIG('foo'), function(){
       echo 'after foo';
   });

The above code will output.

.. code-block:: php

   // fooafter foo





