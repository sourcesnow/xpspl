.. /emit.php generated using docpx on 01/12/13 06:44pm
emit
====

.. function:: emit()


    Emit a signal, returning the resulting ``SIG`` object.

    :param signal $signal: Any SIG_Base object string or integer, an invalid
                         ``$signal`` throws a
    :param object $context: Context signal

    :rtype: object SIG


Example
+++++++
 
Emitting a signal.

.. code-block:: php

   <?php
   // Emit the foo signal
   emit('foo');



