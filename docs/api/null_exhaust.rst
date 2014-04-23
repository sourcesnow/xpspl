.. /null_exhaust.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_null_exhaust
***************


.. function:: xp_null_exhaust($process)


    Nullifies a processes exhaustion rate.
    
    .. note::
    
        Once a process is registered with a null exhaust it will **never**
        be purged from the processor unless a ``xp_flush`` is called.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Example #1 Basic Usage
######################

This example installs a null exhaust process which calls an awake signal
every 10 seconds creating an interval.

.. code-block:: php

   <?php
   import('time');

   time\awake(10, xp_null_exhaust(function(){
       echo "10 seconds";
   }));





