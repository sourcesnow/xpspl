.. /delete_process.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_delete_process
*****************


.. function:: xp_delete_process($signal, $process)


    Deletes an installed signal process.
    
    .. note::
    
       The \\XPSPL\\Process object given must be the same returned or created
       when the process was installed.

    :param object: \\XPSPL\\SIG signal to remove process from.
    :param object: \\XPSPL\\Process object to remove.

    :rtype: void 


Example #1 Basic Usage
######################

.. code-block::php

   <?php
   // Create a new process on the foo SIG.
   $process_one = xp_signal(XP_SIG('foo'), function(){
       echo 'foo';
   });

   $process_two = xp_signal(XP_SIG('foo'), function(){
       echo 'bar';
   });

   // Delete process_one using the returned \XPSPL\Process object
   xp_delete_process(XP_SIG('foo'), $process_one);

   // Emit foo
   xp_emit(XP_SIG('foo'));

The above code will output.

.. code-block:: php

   bar





