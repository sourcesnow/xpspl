.. /delete_process.php generated using docpx v1.0.0 on 03/02/14 12:15pm


xp_delete_process
*****************


.. function:: xp_delete_process($signal, $process)


    Deletes an installed signal process.

    :param string|integer|object: Signal process is attached to.
    :param object: Process.

    :rtype: void 


Delete installed process
########################

Removes the installed process from the foo signal.

.. code-block::php

   <?php
   $process = xp_signal(XP_SIG('foo'), function(){});

   xp_delete_process(XP_SIG('foo'), $process);





