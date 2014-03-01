.. /before.php generated using docpx v1.0.0 on 02/28/14 07:47pm


xp_before
*********


.. function:: xp_before($signal, $process)


    Execute a function before a signal is emitted.

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

   xp_before(XP_SIG('foo'), function(){
       echo 'before foo';
   });

   // results when foo is emitted
   // before foo foo





