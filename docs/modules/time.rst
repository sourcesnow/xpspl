.. ftp::

Time Module
-----------

The Time module provides time based code execution for XPSPL.

Installation
____________

The Time Module is bundled with XPSPL as of version 2.0.0.

XPSPL
^^^^^

XPSPL **>= 2.0**

Configuration
_____________

The Time Module has no runtime configuration options available.

Usage
_____

Importing
^^^^^^^^^

.. code-block:: php

    <?php

    xp_import('time');

.. note::

   By default all times are in seconds.

Timeouts
^^^^^^^^

Timeouts are functions executed once after X amount of seconds, the time module
supports timeouts using the ``awake`` function.

The below example demonstrates executing a timeout after 30 seconds.

.. code-block:: php

    <?php

    xp_import('time');

    time\awake(30, function(){
        echo '30 seconds just passed';
    });

Intervals
^^^^^^^^^

Intervals are functions executed every X amount of seconds for a set exhaustion,
the time module supports intervals using the ``awake`` function and defining an
exhausting on the process.

The example below demonstrates an interval that runs every 30 seconds 10 times.

.. note::

   Setting a null exhaustion allows for permanently running intervals, which
   can only be removed by manually deleting the signal using ``xp_signal_delete``.

Milliseconds and Microseconds Instructions
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The wait time period can be defined as seconds, milliseconds and microseconds.

Defining the instruction of time can be done by providing the ``$instruction``
to the ``awake`` function usign the time instruction constants.

* ``TIME_SECONDS`` Second instruction
* ``TIME_MILLISECONDS`` Millisecond instruction
* ``TIME_MICROSECONDS`` Microsecond instruction

The example below demonstrates executing timeouts in seconds, milliseconds and
microseconds.

.. warning::

    Microsecond precision *CANNOT* be guaranteed.

.. code-block:: php

    <?php

    xp_import('time');

    // SECONDS
    time\awake(30, function(){
        echo '30 seconds just passed';
    }, TIME_SECONDS);

    // MILLISECONDS
    time\awake(30, function(){
        echo '1000 milliseconds just passed';
    }, TIME_MILLISECONDS);

    // SECONDS
    time\awake(30, function(){
        echo '1000 microseconds just passed';
    }, TIME_MICROSECONDS);

CRON Based Time
^^^^^^^^^^^^^^^

The CRON syntax is supported for executing signals based on the CRON syntax using
the ``CRON`` api function.

.. note::

    CRON based time signals automatically register themselves with a null
    exhaust, an exhaustion rate should only be defined when it is explicitly
    required.

The example below demonstrates executing a signal everyday at 12pm.

.. code-block:: php

    <?php
    // CRON
    time\CRON('12 * * * *', function(){
        echo 'It is 12 oclock!';
    });

API
___

All functions and classes are under the ``time`` namespace.

.. function:: time\\awake($time, $callback, [$instruction = 4])


    Wakes the system loop and runs the provided function.

    :param integer: Time to wake in.
    :param callable: Callable function.
    :param integer: The time instruction. Default = Seconds

    :rtype: array [signal, process]


.. function:: time\\CRON($cron, $process)


    Wakes the system using the Unix CRON expressions.

    If no priority is provided with the ```$process``` it is set to null.

    :param string: CRON Expression
    :param callable: Callback function to run

    :rtype: array [signal, process]

