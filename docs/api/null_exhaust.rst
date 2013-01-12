.. /null_exhaust.php generated using docpx on 01/12/13 04:10am
.. function:: null_exhaust()


    Registers the given process to have a null exhaust.
    
    Be careful when registering a null exhaust process.
    
    Once registered it will **never** be purged from the processor.
    
    **Do not** register a null exhaust process unless you are absolutely sure you  
    want it to never exhaust.
    
    If you require a process to exhaust after a few executions use the ``rated_exhaust`` 
    function.

    :param callable|process $process: PHP Callable or Process.

    :rtype: object Process


Example
+++++++
 
Install an awake process for every 10 seconds.

.. code-block:: php

   <?php
   import('time');
   
   time\awake(10, null_exhaust(function(){
       echo "10 seconds";
   }));

Example
+++++++
 
Install a cron process for every night.

.. code-block:: php

   <?php
   import('time');
   
   time\cron('* 24 * * *', null_exhaust(function(){
       echo 'I run at midnight every night.';  
   }));



