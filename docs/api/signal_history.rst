.. /signal_history.php generated using docpx v1.0.0 on 02/28/14 07:47pm


xp_signal_history
*****************


.. function:: xp_signal_history()


    Returns the current signal history.
    
    The returned history is stored in an array using the following indexes.
    
    .. code-block:: php
    
       <?php
       $array = [
           0 => Signal Object
           1 => Time in microseconds since Epoch at emittion
       ];

    :rtype: array 


Counting emitted signals
########################

This counts the number of ``XP_SIG('foo')`` signals that were emitted.

.. code-block:: php

   <?php
   $sig = XP_SIG('foo');
   // Emit a few foo objects
   for($i=0;$i<5;$i++){
       xp_emit($sig);
   }
   $emitted = 0;
   foreach(xp_signal_history() as $_node) {
       if ($_node[0] instanceof $sig) {
           $emitted++;
       }
   }
   echo $emitted;





