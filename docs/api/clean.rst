.. /clean.php generated using docpx v1.0.0 on 02/28/14 07:47pm


xp_clean
********


.. function:: xp_clean([$history = false])


    Will scan and remove any processes and signals that can no longer be emitted.
    
    .. note::
    
       This *DOES NOT* flush the processor and will leave emittable signals in
       the processor.
    
       A signal is determined to be emittable only if it has installed processes
       that have not exhausted.

    :param boolean: Erase any history of removed signals.

    :rtype: void 


Basic Usage
###########

Basic usage example demonstrating cleaning old signals and processes.

.. code-block:: php

    <?php

    xp_signal(XP_SIG('Test'), function(){
        echo 'SIG Test';
    });

    xp_signal(XP_SIG('Test_2'), function(){
        echo 'SIG Test 2';
    });

    xp_emit(XP_SIG('Test'));

    xp_clean();

When ran the above code will output `SIG Test` and then remove the signal
the Test_2 signal will not be removed since it still contains an emittable
signal.





