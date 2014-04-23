.. /on_shutdown.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_on_shutdown
**************


.. function:: xp_on_shutdown($function)


    Registers a function to call when the processor shuts down.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process


Example #1 Basic Usage
######################

.. code-block:: php

    <?php

    xp_on_shutdown(function(){
        echo 'Shutting down the processor!';
    });

    xp_wait_loop();

The above code will output.

.. code-block:: php

    Shutting down the processor!





