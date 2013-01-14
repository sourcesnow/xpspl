.. /remove_process.php generated using docpx on 01/14/13 01:12pm
remove_process
==============

.. function:: remove_process($signal, $process)


    Removes an installed signal process.

    :param string|integer|object $signal: Signal process is attached to.
    :param object $process: Process.

    :rtype: void 


Removing installed processes
----------------------------
 
Removes the installed process from the foo signal.

.. code-block::php

   <?php
   $process = signal('foo', function(){});
   
   remove_process('foo', $process);



