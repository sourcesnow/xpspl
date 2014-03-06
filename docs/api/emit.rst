.. /emit.php generated using docpx v1.0.0 on 03/06/14 11:19am


xp_emit
*******


.. function:: xp_emit($signal, [$context = false])


    Emits a signal.
    
    This will execute all processes, before and after functions installed to the
    signal.
    
    Returns the executed ``\XPSPL\SIG`` object.
    
    .. note::
    
       When emitting unique signals, e.g.. complex, routines or defined uniques
       the unique ``\XPSPL\SIG`` object installed must be provided.
    
    Once a signal is emitted the following execution chain takes place.
    
    1. Before process functions
    2. Process function
    3. After process function

    :param signal: \XPSPL\SIG object to emit.
    :param object: \XPSPL\SIG object context to execute within.

    :rtype: object \XPSPL\SIG


Example #1 Basic Usage
######################

.. code-block:: php

    <?php

    // Install a process on the foo signal
    xp_signal(XP_SIG('foo'), function(){
        echo 'foo';
    });

    // Emit the foo signal
    xp_emit(XP_SIG('foo'));

The above example will output.

.. code-block:: php

    foo

Example #2 Unique Signals
#########################

.. code-block:: php

   <?php

   // Create a unique Foo signal.
   class SIG_Foo extends \XPSPL\SIG {
       // declare it as unique
       protected $_unique = true;
   }

   // Create a SIG_Foo unique object
   $foo = new SIG_Foo();

   signal($foo, function(){
       echo "foo";
   });

   // Emit the SIG_Foo and another unique SIG_Foo
   xp_emit($foo);
   xp_emit(new Foo());

The above code will output.

.. code-block:: php

   foo

Example #3 Complex Signals
##########################

.. code-block:: php

    <?php

    // Create our 3 required signals.
    class SIG_Bells extends \XPSPL\SIG {}
    class SIG_Bride extends \XPSPL\SIG {}
    class SIG_Groom extends \XPSPL\SIG {}

    // Create a complex signal that will emit when a wedding takes place
    // based on 3 seperate signals, SIG_Bells, SIG_Bride and SIG_Groom.
    class SIG_Wedding extends \XPSPL\SIG_Complex {

        // Keep track if each requirement has already emitted
        protected $_bells = false;
        protected $_bride = false;
        protected $_groom = false;

        // Create an evaulation method to evaluate the runtime
        public function evaluate($signal = null)
        {
          switch ($signal) {
            case $signal instanceof SIG_Bells:
                $this->_bells = true;
                break;
            case $signal instanceof SIG_Bride:
                $this->_bride = true;
                break;
            case $signal instanceof SIG_Groom:
                $this->_groom = true;
                break;
          }
          if ($this->_bells === true &&
                $this->_bride === true &&
                $this->_groom === true) {
            $this->_bells = false;
            $this->_groom = false;
            $this->_bride = false;
            return true;
          }
          return false;
        }
    }

    // Install a process for complex signal.
    xp_signal(new SIG_Wedding(), function(){
        echo 'The wedding is happening!'.PHP_EOL;
    });

    // Emit SIG_Bells, SIG_Bride and SIG_Groom
    xp_emit(new SIG_Bells());
    xp_emit(new SIG_Bride());
    xp_emit(new SIG_Groom());

The above code will output.

.. code-block:: php

    The wedding is happening!




Created on 03/06/14 11:19am using `Docpx <http://github.com/prggmr/docpx>`_