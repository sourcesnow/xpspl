.. /process.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_process
**********


.. function:: xp_process($callable)


    Generates a \XPSPL\Process object from the given PHP callable.
    
    .. note::
    
       See the ``priority`` and ``exhaust`` functions for setting the priority
       and exhaust of the created process.

    :param callable: 

    :rtype: void 


Example #1 Basic Usage
######################

Creates a new XPSPL Process object.

.. code-block::php

   <?php

   $process = xp_process(function(){});
	  // The process can now be installed to a signal.
   xp_signal(XP_SIG('foo'), $process);





