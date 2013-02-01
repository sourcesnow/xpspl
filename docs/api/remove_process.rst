.. remove_process.php generated using docpx on 01/31/13 10:44pm


Function - remove_process
*************************

remove_process
==============

.. function:: remove_process($signal, $process)


    Removes an installed signal process.

    :param string|integer|object: Signal process is attached to.
    :param object: Process.

    :rtype: void 


Removing installed processes
############################

Removes the installed process from the foo signal.

.. code-block::php

   <?php
   $process = signal('foo', function(){});
   
   remove_process('foo', $process);




Last updated on 01/31/13 10:44pm