.. /threaded_process.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_threaded_process
*******************


.. function:: xp_threaded_process($process)


    Enables a process to execute within it's own thread.
    
    .. warning::
    
       Threaded functionality within XPSPL is *highly* experiemental...
    
       This has not been tested in a production environment.
    
    .. note::
    
       To enable threads you must install and enable the PECL pthreads extension.
    
       Once installed threads will be automatically enabled.


Example #1 Basic Usage
######################

Executing processes in their own thread.

.. code-block:: php

   <?php

   xp_signal(XP_SIG('foo'), threaded_process(function($sig){
       print 'Executed in own thread';
       sleep(10);
   });

    :param callable: PHP Callable

    :rtype: void 





