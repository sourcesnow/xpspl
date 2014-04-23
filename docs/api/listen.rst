.. /listen.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_listen
*********


.. function:: xp_listen($listener)


    Registers a new listener.
    
    Listeners are special objects that register each publically available 
    method as an executing process using the method name.
    
    .. note::
    
        Public methods that are declared with a prepended underscore "_" are 
        ignored.

    :param object: The object to register.

    :rtype: void 


Example #1 Basic Usage
######################

.. code-block:: php

    <?php

    class My_Listener extends \XPSPL\Listener 
    {
        // Register a process for the foo signal.
        public function foobar($signal) {
            echo 'foobar';
        }
    }

    xp_listener(new My_Listener());

    xp_emit(XP_SIG('foobar'));

The above code will output.

.. code-block:: php

    foobar





