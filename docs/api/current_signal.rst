.. /current_signal.php generated using docpx v1.0.0 on 03/02/14 12:15pm


xp_current_signal
*****************


.. function:: xp_current_signal([$offset = false])


    Retrieve the current signal in execution.

    :param integer: If a positive offset is given it will return from
                          the top of the signal stack, if negative it will
                          return from the bottom (current) of the stack.

    :rtype: object \\XPSPL\\SIG


Basic Usage
###########

Basic usage example.

.. code-block:: php

    <?php

    xp_signal(XP_SIG('foo'), function(\XPSPL\SIG $signal){
        $a = xp_current_signal();
        echo $a->get_index();
    });

    // Results in 'foo'

Retrieve parent signal.
#######################

The parent signal can be fetched by using an offset of ```-2```.

.. code-block:: php

    <?php

    xp_signal(XP_SIG('bar'), function(){
        xp_emit(XP_SIG('foo'));
    });

    xp_signal(XP_SIG('foo'), function(){
        $a = xp_current_signal(-2);
        echo $a->get_index();
    });

    // Results in 'bar'





