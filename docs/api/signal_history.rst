.. /signal_history.php generated using docpx on 02/01/13 10:00pm


Function - signal_history
*************************


.. function:: signal_history()


    Returns the current signal history.
    
    The returned history is stored in an array using the following indexes.
    
    .. code-block:: php
    
       <?php
       $array = [
           0 => Signal Object
           1 => Time in microseconds since EPOC at emittion
       ];

    :rtype: array 


Getting the signal history.
###########################

This returns the current signal history and checks for any ``SIG('foo')`` 
objects that were emitted.

.. code-block:: php

   <?php
   $sig = SIG('foo');
   // Emit a few foo objects
   for($i=0;$i<5;$i++){
       emit($sig);
   }
   $emitted = 0;
   foreach(signal_history() as $_node) {
       if ($_node[0] instanceof $sig) {
           $emitted++;
       }
   }
   echo $emitted;




Last updated on 02/01/13 10:00pm