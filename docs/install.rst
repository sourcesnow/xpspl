.. _install:

Installing XPSPL
----------------

Requirements
============

XPSPL requires  **>= PHP 5.4**.

Optional
========

C Judy 1.0.4
PECL Judy 0.1.4

The Judy library demonstrates improving the database by giving storage a linear 
scale of ~39us up to the tested 262144.

Both required libraries are bundled in the ``library`` folder with XPSPL.

For installation of Judy C see the README.

For installation of Judy PECL.

.. code-block:: sh

    $: phpize
    $: ./configure
    $: make
    $: make test
    $: sudo make install

Install
=======

XPSPL installation is over the network with a CLI script_.

.. _script: https://raw.github.com/prggmr/xpspl/master/install

The installation requires the **CURL** and **ZIP** libraries.

.. code-block:: console

    curl -s https://raw.github.com/prggmr/xpspl/master/install | sudo sh

Updates
=======

Once installed updates can be performed by using the ``--update`` option and simply follow the prompt.

.. code-block:: console

    xpspl --update

Windows
=======

Currently a Windows installation guide does not exist.

.. todo::

    Add windows install guide.
