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

Processing and emitting signals is available using the ``xp_signal`` and ``xp_emit`` functions.

.. include:: api/signal.rst

.. include:: api/emit.rst

Environment
%%%%%%%%%%%

XPSPL ships with the ``xpspl`` command for directly loading into an environment.

XPSPL understands the following.

.. code-block:: text

    usage: xpspl [-c|--config=<file>] [-d] [-h|--help] [-p|--passthru] [--test]
                  [--test-cover] [-v|--version] [-j|--judy]
                  <file>
    Options:
      -c/--config   Load the giving file for configuration
      -d            XPSPL Debug Mode
      -h/--help     Show this help message.
      -j/--judy     Enable judy support
      -p/--passthru Ignore any subsequent arguments and pass to <file>.
      --test        Run the XPSPL unit tests.
      --test-cover  Run unit tests and generate code coverage.
      -v/--version  Displays current XPSPL version.
