.. /wait_loop.php generated using docpx v1.0.0 on 03/06/14 11:19am


xp_wait_loop
************


.. function:: xp_wait_loop()


    Begin the XPSPL wait loop.
    
    The XPSPL wait loop is a core function of XPSPL and *MUST* be called as the 
    final function to execute any type of complex event, this includes time, 
    networking and ftp operations.

    :rtype: void .. warning::

   This is a *BLOCKING* function.

   A loop based signal time, networking, ftp ... etc must be registered 
   before calling the wait_loop.

   Any code underneath the function call will *NOT* be executed until 
   the processor halts execution.


Basic Usage
###########

Basic usage example demonstrating using the loop for time based code.

.. code-block:: php

   <?php

   // Import time module
   xp_import('time');

   xp_time\awake(10, function(){
       echo '10 seconds passed';
   });

   xp_wait_loop()

Automatic shutdown
##################

The processor loop has built in support for automatically shutting down when 
it detects there is nothing else it will ever do.

This example demonstrates the loop shutting down after emitting 5 time based 
signals.

.. code-block:: php




Created on 03/06/14 11:19am using `Docpx <http://github.com/prggmr/docpx>`_