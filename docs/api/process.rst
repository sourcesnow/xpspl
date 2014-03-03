.. /process.php generated using docpx v1.0.0 on 03/03/14 10:55am


xp_process
**********


.. function:: xp_process($callable)


    Generates a \XPSPL\Process object from the given PHP callable.
    
    .. note::
    
       See the ``priority`` and ``exhaust`` functions for setting the priority
       and exhaust of the created process.

    :param callable: 

    :rtype: void 


Creates a new XPSPL Process object.
###################################

.. code-block::php

   <?php

   $process = xp_process(function(){});

   xp_signal(XP_SIG('foo'), $process);




Created on 03/03/14 10:55am using `Docpx <http://github.com/prggmr/docpx>`_