.. /delete_signal.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_delete_signal
****************


.. function:: xp_delete_signal($signal, [$history = false])


    Delete a signal from the processor.

    :param string|object|int: Signal to delete.
    :param boolean: Erase any history of the signal.

    :rtype: boolean 


Example #1 Basic Usage
######################

.. code-block:: php

   <?php
   // Install process on signal foo
   xp_signal(XP_SIG('foo'), function(){});
   // Delete the signal foo
   xp_delete_signal(XP_SIG('foo'));
   // Emit the signal foo
   xp_emit(XP_SIG('foo'));





