.. before.php generated using docpx on 02/21/13 08:52pm


Function
********

before
======

.. function:: before()


    Installs the given process to interrupt the signal ``$signal`` when emitted.
    
    Interruption processes installed using this function interrupt directly 
    after a signal is emitted.
    
    .. warning:: 
    
       Interruptions are not a fix for improperly executing process priorities 
       within a signal.
       
       If unexpected process priority are being executed debug them... 
    
    .. note::
    
       Interruptions use the same prioritizing as the Processor.

    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Install a interrupt process before foo
RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5

High priority process will always execute first immediatly following 
interruptions.

.. code-block:: php

   <?php
   
   signal(SIG('foo'), function(){
       echo 'foo';
   });

   before(SIG('foo'), function(){
       echo 'before foo';
   });

   // results when foo is emitted
   // foobefore foo

Before Interrupt Process Priority
RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5

Install before interrupt processes with priority.

.. code-block:: php

   <?php
   signal(SIG('foo'), function(){
       echo 'foo';
   })
   
   before(SIG('foo'), low_priority(function(){
       echo 'low priority foo';
   }));
   
   before(SIG('foo'), high_priority(function(){
       echo 'high priority foo';
   }));
   
   emit(SIG('foo'));

   // results
   // highpriorityfoo lowpriorityfoo foo



