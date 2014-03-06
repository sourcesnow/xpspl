.. /sig.php generated using docpx v1.0.0 on 03/05/14 10:23pm


XP_SIG
******


.. function:: XP_SIG($signal)


    Generates an XPSPL SIG object from the given ``$signal``.
    
    This function is only a shorthand for ``new SIG($signal)``.

    :param string|: Signal process is attached to.

    :rtype: object \XPSPL\SIG


Creating a SIG.
###############

This will create a SIG idenitified by 'foo'.

.. code-block:: php

   <?php
   xp_signal(XP_SIG('foo'), function(){
       echo "HelloWorld";
   });

   xp_emit(XP_SIG('foo'));





