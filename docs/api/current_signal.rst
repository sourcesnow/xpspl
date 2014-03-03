.. /current_signal.php generated using docpx v1.0.0 on 03/03/14 10:55am


xp_current_signal
*****************


.. function:: xp_current_signal([$offset = false])


    Retrieve the current signal in execution.

    :param integer: If a positive offset is given it will return from
                          the top of the signal stack, if negative it will
                          return from the bottom (current) of the stack.

    :rtype: object \\XPSPL\\SIG


Example #1 Basic Usage
######################

.. code-block:: php

    <?php

    xp_signal(XP_SIG('foo'), function(\XPSPL\SIG $signal){
        $a = xp_current_signal();
        echo $a->get_index();
    });

The above code will output.

.. code-block:: php

   foo

Example #2 Parent Signals
#########################

Parent signals can be fetched by using a negative offset ``< -1``.

.. code-block:: php

    <?php

    // Install a process on the bar SIG
    xp_signal(XP_SIG('bar'), function(){
        // Emit foo within bar
        xp_emit(XP_SIG('foo'));
    });

    // Install a process on the foo SIG
    xp_signal(XP_SIG('foo'), function(){
        // Get the parent of foo
        $a = xp_current_signal(-2);
        echo $a->get_index();
    });

The above code will output.

.. code-block:: php

   bar




Created on 03/03/14 10:55am using `Docpx <http://github.com/prggmr/docpx>`_