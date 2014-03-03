.. /after.php generated using docpx v1.0.0 on 03/03/14 10:55am


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

Example #2 Class Signals
########################

.. code-block:: php

    <?php

    class SIG_Foo extends \XPSPL\SIG {}

    xp_signal(new SIG_Foo(), function(){
        echo 'foo';
    });

    xp_after(new SIG_Foo(), function(){
        echo 'bar';
    });

The above code will output.

.. code-block:: php

    foobar




Created on 03/03/14 10:55am using `Docpx <http://github.com/prggmr/docpx>`_