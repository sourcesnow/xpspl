Quickstart
----------


.. contents::


Installing XPSPL
%%%%%%%%%%%%%%%%

XPSPL is installed using (composer_).

.. _composer: http://getcomposer.org

.. code-block:: console

  require: "prggmr/xpspl": "v5.0.0"

Once installed XPSPL's API will be available after including composer's ``vender/autoload.php``.

Processing and Emitting signals
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

Processing and emitting signals  available using the ``xp_signal`` and ``xp_emit`` functions.

.. include:: api/signal.rst

.. include:: api/emit.rst


Time
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
    xp_import('time');

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
    xp_import('network');
    xp_import('time');

    $server = network\connect('0.0.0.0', ['port' => '1337']);

    $server->on_connect(xp_null_exhaust(function(network\SIG_Connect $sig_connect){
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
    xp_before(XP_SIG('foo'), function($signal){
        echo "I RAN";
        $signal->bar = 'foo';
    });

    // Handle Foo
    xp_signal(XP_SIG('foo'), function($signal){
        echo $signal->bar;
    });

    // After foo is emitted unset bar in the event
    xp_after(XP_SIG('foo'), function($signal){
        unset($signal->bar);
    });

    $signal = xp_emit(XP_SIG('foo'));


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
