.. /clean.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_clean
********


.. function:: xp_clean([$history = false])


    Scans and removes non-emittable signals and processes.
    
    .. note::
    
       This DOES NOT flush the processor.
    
       A signal is determined to be emittable only if it has installed processes
       that have not exhausted.

    :param boolean: Erase any history of removed signals.

    :rtype: void 


Example #1 Basic Usage
######################

Basic usage example demonstrating cleaning old signals and processes.

.. code-block:: php

    <?php

    xp_signal(XP_SIG('Test'), xp_exhaust(1, function(){
        echo 'SIG Test';
    }));

    xp_signal(XP_SIG('Test_2'), function(){
        echo 'SIG Test 2';
    });

    xp_emit(XP_SIG('Test'));

    xp_clean();
    var_dump(xp_find_signal(XP_SIG('Test')));

The above code will output.

.. code-block:: php

    SIG Test null





