.. /complex_sig.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_complex_sig
**************


.. function:: xp_complex_sig($function, [$rebind_context = true])


    Allows for performing complex signal processing using callable PHP variables.
    
    A ``\Closure`` will be bound into an object context which allows maintaining
    variables across emits within ``$this``.
    
    .. note::
    
       A ``\Closure`` can remain bound to its original context by passing
       ``$rebind_context`` as ``false``.

    :param callable: Callable variable to use for evaluation.
    :param boolean: Rebind the given closures context to this
                                  object.

    :rtype: \\XPSPL\\SIG_Complex Complex signal registered to the processor.


Example #1 Detecting a wedding.
###############################

.. code-block:: php

    <?php
    // Once a bride, groom and bell signals are emitted we emit the wedding.
    $wedding = xp_complex_sig(function($signal){
        if (!isset($this->reset) || $this->reset) {
            $this->reset = false;
            $this->bride = false;
            $this->groom = false;
            $this->bells = false;
        }
        switch (true) {
            // Signals can be compared using the compare method
            // this will return if the signals are identical
            case $signal->compare(XP_SIG('groom')):
                $this->groom = true;
                break;
            case $signal->compare(XP_SIG('bride')):
                $this->bride = true;
                break;
            case $signal->compare(XP_SIG('bells')):
                $this->bells = true;
                break;
        }
        if ($this->groom && $this->bride && $this->bells) {
            $this->reset = true;
            return true;
        }
        return false;
    });

    xp_signal($wedding, function(){
        echo 'A wedding just happened.';
    });

    xp_emit(XP_SIG('bride'));
    xp_emit(XP_SIG('groom'));
    xp_emit(XP_SIG('bells'));

The above code will output.

.. code-block:: php

    A wedding just happened.

Example #2 Detecting a wedding using network recieved signals.
##############################################################

.. code-block:: php

  <?php

  xp_import('network');

  $server = network\connect('0.0.0.0', ['port' => 8000]);
  // Setup a server that emits a signal of recieved data
  $server->on_read(function($signal){
      $read = trim($signal->socket->read());
      if ($read == null) {
        return false;
      }
      xp_emit(XP_SIG($read));
  });

  // Once a bride, groom and bell signals are emitted we emit the wedding.
  $wedding = xp_complex_sig(function($signal){
      if (!isset($this->reset) || $this->reset) {
        $this->reset = false;
        $this->bride = false;
        $this->groom = false;
        $this->bells = false;
      }
      switch (true) {
        case $signal->compare(XP_SIG('groom')):
            $this->groom = true;
            break;
        case $signal->compare(XP_SIG('bride')):
            $this->bride = true;
            break;
        case $signal->compare(XP_SIG('bells')):
            $this->bells = true;
            break;
      }
      if ($this->groom && $this->bride && $this->bells) {
        $this->reset = true;
        return true;
      }
      return false;
  });

  xp_signal($wedding, function(){
      echo 'A wedding just happened.';
  });

  // Start the wait loop
  xp_wait_loop();

The above code will output.

.. code-block:: php

   A wedding just happened.

Once the ``bride``, ``groom`` and ``bells`` signals are emitted from the
network connection the complex signal will emit the wedding.





