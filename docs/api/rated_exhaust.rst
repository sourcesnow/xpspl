.. rated_exhaust.php generated using docpx on 01/31/13 10:44pm


Function - rated_exhaust
************************

rated_exhaust
=============

.. function:: rated_exhaust($limit, $process)


    Registers the given process to have the given exhaust rate.
    
    A rated exhaust allows for you to install processes that exhaust at the set 
    rate rather than 1.
    
    This is useful if you have processes where you need them to execute more than 
    once but only a certain number of times.
    
    If you require a null exhaust process use the ``null_exhaust`` function.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Controlling exahust rate
########################

Installs an awake process for every 2 seconds exhausting after 2 emits.

.. code-block:: php

   <?php
   import('time');
   
   time\awake(10, rated_exhaust(2, function(){
       echo "10 seconds";
   }));




Last updated on 01/31/13 10:44pm