.. /threaded_process.php generated using docpx v1.0.0 on 02/28/14 07:47pm


xp_threaded_process
*******************


.. function:: xp_threaded_process($process)


    Enables a process to execute within it's own thread.
    
    This works only when the PECL package pthreads is installed.
    
    .. warning::
    
       Threaded functionality within XPSPL is still *highly* experiemental...
    
       Use this at your own RISK!.


Executing processes in their own thread.
########################################

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), threaded_process(function($sig){
       print 'Executed in own thread';
       sleep(10);
   });

    :param callable: PHP Callable

    :rtype: void 





