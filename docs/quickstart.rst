Quickstart
----------

This guide covers the following topics,

.. contents::

Examples
________

XPSPL Programming examples. 


Handling and Emitting a signal
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

Register a signal handler and emit a signal.

.. code-block:: php

    <?php

    // Register signal handler
    signal(SIG('foo'), function(){
        echo 'HelloWorld';
    });

    // Now emit the signal
    emit(SIG('foo'));


Scheduled CRON Jobs
%%%%%%%%%%%%%%%%%%%

Perform a scheduled task using CRON syntax.

.. code-block:: php

    <?php

    date_default_timezone_set('America/New_York');

    /**
     * CRON
     *
     * This example demonstrates how to use CRON to awake XPSPL.
     */
    import('time');

    time\CRON('*/1 * * * *', function(){
        echo "Every Minute!".PHP_EOL;
    });

Network Connection
%%%%%%%%%%%%%%%%%%

Establish and communicate on a network connection. 

.. code-block:: php

    <?php

    /**
     * Network Server
     *
     * This example demonstrates a simple network server that says HelloWorld.
     * Waits 5 Seconds and closes the connection.
     */
    import('network');
    import('time');

    $server = network\connect('0.0.0.0', ['port' => '1337']);

    $server->on_connect(null_exhaust(function(network\SIG_Connect $sig_connect){
        if (null !== $sig_connect->socket) {
            echo "Connection " . PHP_EOL;
            $sig_connect->socket->write('HelloWorld');
            $sig_connect->socket->write('Closing connection in 5 seconds');
            time\awake(5, function() use ($sig_connect){
                $sig_connect->socket->write('Goodbye');
                $sig_connect->socket->disconnect();
            });
        }
    }));

Interrupts
%%%%%%%%%%

This example demonstrates using interrupts.

.. code-block:: php

    <?php

    // When foo is emitted insert bar into the event
    before(SIG('foo'), function($signal){
        echo "I RAN";
        $signal->bar = 'foo';
    });

    // Handle Foo
    signal(SIG('foo'), function($signal){
        echo $signal->bar;
    });

    // After foo is emitted unset bar in the event
    after(SIG('foo'), function($signal){
        unset($signal->bar);
    });

    $signal = emit(SIG('foo'));
    var_dump($signal);
    var_dump(isset($signal->bar));

API
___

XPSPL's API is designed to provide programmers with a natural speaking, 
intuitive API.

API functions are globally available under no namespace.

Environment
___________

XPSPL ships with the ``xpspl`` command for loading its environment.

XPSPL understands the following.

.. code-block:: text

    usage: xpspl [-c|--config=<file>] [-d] [-h|--help] [-p|--passthru] [--test]
                  [--test-cover] [-t|--time=<time>] [-v|--version] [-j|--judy]
                  <file>
    Options:
      -c/--config   Load the giving file for configuration
      -d            XPSPL Debug Mode
      -h/--help     Show this help message.
      -j/--judy     Enable judy support
      -p/--passthru Ignore any subsequent arguments and pass to <file>.
      --test        Run the XPSPL unit tests.
      --test-cover  Run unit tests and generate code coverage.
      --update      Update XPSPL to the latest available version.
      -t/--time     Run for the given amount of milliseconds.
      -v/--version  Displays current XPSPL version.
  
Unsupported
___________

Here is a list of unsupported features,

    * Threads and forks
    * epoll, kqueue, poll (select is supported...)
    * Real time

A suitable epoll, kqueue and poll module is planned.

Contributions for these features are always appreciated.