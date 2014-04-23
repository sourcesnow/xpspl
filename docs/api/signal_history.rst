.. /signal_history.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_signal_history
*****************


.. function:: xp_signal_history()


    Returns the current signal history.
    
    The returned history is stored in an array using the following indexes.
    
    .. code-block:: php
    
       <?php
       $array = [
           0 => Signal Object
           1 => UNIX timestamp of execution
       ];

    :rtype: array 


Example #1 Basic Usage
######################

Count the number of ``XP_SIG('foo')`` signals that were emitted.

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

The above code will output.

.. code-block:: php

    5





