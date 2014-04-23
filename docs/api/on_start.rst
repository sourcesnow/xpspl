.. /on_start.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_on_start
***********


.. function:: xp_on_start($function)


    Registers a function to call when the processor starts.

    :param callable|object: Function or process object

    :rtype: object \XPSPL\Process


Example #1 Basic Usage
######################

.. code-block:: php

    <?php

    xp_on_start(function(){
        echo 'The processor started';
    });

    xp_wait_loop();

The above code will output.

.. code-block:: php

    The processor started!





