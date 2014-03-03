.. /null_exhaust.php generated using docpx v1.0.0 on 03/03/14 10:55am


xp_null_exhaust
***************


.. function:: xp_null_exhaust($process)


    Nullifies a processes exhaustion rate.
    
    This allows for processes to exhaust indefiantly when a signal is emitted.
    
    .. note::
    
        Once a process is registered with a null exhaust it will **never**
        be purged from the processor.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Install a null exhaust process.
###############################

This example installs a null exhaust process which calls an awake signal
every 10 seconds creating an interval.

.. code-block:: php

   <?php
   import('time');

   time\awake(10, xp_null_exhaust(function(){
       echo "10 seconds";
   }));




Created on 03/03/14 10:55am using `Docpx <http://github.com/prggmr/docpx>`_