.. _install:

Installing XPSPL
----------------

Requirements
============

XPSPL requires  **>= PHP 5.4**.

Optional
========

PHP FTP_ extension for XPSPL FTP module support.

.. _FTP: http://php.net/manual/en/book.ftp.php

Install
=======

Composer
++++++++

(Composer_) installation.

.. _Composer: http://getcomposer.orgC

.. code-block:: console

	require: "prggmr/xpspl": "v4.0.1"

Manual
++++++

Manual installation is over the network with a CLI. (link_)

.. _link: https://raw.github.com/prggmr/xpspl/master/install

The installation requires the **CURL** and **ZIP** libraries to be installed
on the system.

.. code-block:: console

    curl -s https://raw.github.com/prggmr/xpspl/master/install | sudo sh

Once installed the ``xpspl`` command becomes available.

Updates
=======

Peform updates by running ``xpspl`` with option ``--update``.

.. code-block:: console

    xpspl --update

Optional
========

C Judy 1.0.4
PECL Judy 0.1.4

The Judy library demonstrates improving the database by giving storage a linear
average performance of 39us per write to a tested 262144.

For installation of Judy C see the README.

For installation of Judy PECL visit here_.

.. _here: http://pecl.php.net/package/Judy

Windows
=======

Currently a Windows installation guide does not exist.

.. todo::

    Add windows install guide.
