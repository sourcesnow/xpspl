.. prggmr documentation master file, created by
   sphinx-quickstart on Wed Dec 19 20:57:45 2012.

XPSPL - Signal and Event Library for PHP.
=====================================

XPSPL high performance signal and event library for PHP.

Made in Orlando_.

.. _Orlando:  http://orlandote.ch/

Table of Contents
-----------------

.. toctree::
   :maxdepth: 2
   :glob:

   *

.. contents::

API
---

All API functions are non-namespaced, globally available.

.. toctree::
   :maxdepth: 1
   :glob:

   api/*

Modules
-------

XPSPL Bundled modules.

.. toctree::
   :maxdepth: 1

   modules/ftp

Source
------

XPSPL is hosted on https://github.com/prggmr/XPSPL.


Performance
-----------

Performance testing using a 2.0 GHz Intel Core 2 Duo.

Linear signal emit performance.

.. image:: emit_graph_upper.png

Performance Tests
%%%%%%%%%%%%%%%%%

.. code-block:: php

   --------------------------------------
   Total tests performed 5,242,800
   --------------------------------------
   Average Processes Installed - 0.0009126066 seconds
   Tests Performed : 1,310,700
   --------------------------------------
   --------------------------------------
   Average Signals Emitted - 0.0001160003 seconds
   Tests Performed : 1,310,700
   --------------------------------------
   --------------------------------------
   Average Signal Registration - 0.0003996142 seconds
   Tests Performed : 1,310,700
   --------------------------------------
   --------------------------------------
   Average Loops Performed - 0.0003038336 seconds
   Tests Performed : 1,310,700
   --------------------------------------

Author
------

XPSPL has been designed and developed by Nickolas Whiting.

Support
-------

Mailing list
____________

A mailing list provided by Google Groups_.

.. _Groups: https://groups.google.com/forum/?fromgroups#!forum/prggmr


.. IRC
.. ___

.. An IRC channel by irc.freenode.net ``#prggmr``.

Source
------

XPSPL is hosted on Github_.

.. _Github: http://github.com/prggmr/XPSPL

XPSPL Internal Documentation

The core classes and functions of XPSPL.

.. toctree::
   :maxdepth: 1
   :glob:

   src/*
   src/*/*
