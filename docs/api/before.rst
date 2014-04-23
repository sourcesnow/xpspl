.. /before.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_before
*********


.. function:: xp_before($signal, $process)


    Execute a function before a signal is emitted.

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

   xp_before(XP_SIG('foo'), function(){
       echo 'before foo';
   });

   // results when foo is emitted

The above code will output.

.. code-block:: php

   // before foo foo





