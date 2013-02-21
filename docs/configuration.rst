.. configuration::

Configuration
=============

Configuration options are defined in constants before loading the library.

Constants
---------

XPSPL_DEBUG
+++++++++++
XPSPL Debug mode

When debug mode is turned off an exception handler is installed that 
automatically removes the processor traces from the stack.

XPSPL_SIGNAL_HISTORY
++++++++++++++++++++
Signal History

Boolean option for the signal history. 

By default it is ``false``.

XPSPL_PURGE_EXHAUSTED
+++++++++++++++++++++
Remove Exhausted processes

Boolean option to automatically remove exhausted signals from the processor.

By default this settings is ``true``.

XPSPL_MODULE_DIR
++++++++++++++++
Module Directory

Directory to look for modules.

By default it is set to the ``module`` directory in XPSPL.

XPSPL_PROCESS_DEFAULT_EXHAUST
+++++++++++++++++++++++++++++
Default process exhaustion

Integer option defining the default exhausting of a process.

By default it is ``1``.

XPSPL_PROCESS_DEFAULT_PRIORITY
++++++++++++++++++++++++++++++
Process default priority

Integer option defining the default priority of all processes.

By default it is ``10``.

XPSPL_JUDY_SUPPORT
++++++++++++++++++
Judy is an optional database configuration.

http://xpspl.prggmr.org/en/xspel/install.html#optional

Currently this is experimental as an attempt to improve performance.

Once stable this will automatically be enabled if Judy is detected.

Last updated on 02/08/13 05:30pm