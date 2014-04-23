.. /exhaust.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_exhaust
**********


.. function:: xp_exhaust($limit, $process)


    Defines the number of times a process will execute when a signal is emitted.
    
    .. note::
    
        By default all processes have an exhaust rate of null.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Example #1 Basic Usage
######################

Defines the given process with an exhaust of 5.

.. code-block:: php

   <?php

	  // Install a process for the foo signal that will execute up to 5 times.
   xp_signal(XP_SIG('foo'), xp_exhaust(5, function(){
       echo 'foo';
   });

   for($i=0;$i<10;$i++){
       xp_emit('foo');
   }

The above code will output.

.. code-block:: php

    foofoofoofoofoo

Example #2 Creating a timeout
#############################

.. code-block:: php

    <?php

    // Import the time module
    xp_import('time');

    time\awake(10, xp_exhaust(1, function(){
        echo 'This will execute only once.';
    });

The above code will output.

.. code-block:: php

    This will execute only once.





