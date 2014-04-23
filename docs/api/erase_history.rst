.. /erase_history.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_erase_history
****************


.. function:: xp_erase_history()


    Erases the entire signal history.

    :rtype: void 


Example #1 Basic Usage
######################

.. code-block:: php

    <?php

    // Create some history
    xp_signal(XP_SIG('foo'), function(){});
    for ($i=0;$i<10;$i++) {
        xp_emit(XP_SIG('foo'));
    }
    
    // Dump the history count
    var_dump(count(xp_signal_history()));

    // Erase the history
    xp_erase_history();

    var_dump(count(xp_signal_history()));

The above code will output.

.. code-block:: php

    10 ... 0





