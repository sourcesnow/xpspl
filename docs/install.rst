.. _install:

Install
-------

Requirements
============

XPSPL requires  **>= PHP 5.4**.


Composer
++++++++

XPSPL is installed using (composer_).

.. _composer: http://getcomposer.org

.. code-block:: console

	require: "prggmr/xpspl": "v5.0.0"

Once installed XPSPL's API will be available after including composer's ``vender/autoload.php``.

Manual
++++++

.. warning::

	This is the legacy installation method.

	Only install XPSPL using this if you are using XPSPL < v5.0.0

The manual installation is over the network with a CLI. (link_)

.. _link: https://raw.github.com/prggmr/xpspl/master/install

The installation requires the **CURL** and **ZIP** libraries to be installed
on the system and is the legacy installation.

.. code-block:: console

    curl -s https://raw.github.com/prggmr/xpspl/master/install | sudo sh

Optional
========

FTP Module
++++++++++

PHP FTP_ extension for XPSPL FTP module support.

.. _FTP: http://php.net/manual/en/book.ftp.php

Judy
++++

C Judy 1.0.4
PECL Judy 0.1.4

The Judy library demonstrates improving the database by giving sptorage a linear
average performance of 39us per write to a tested 262144.

For installation of Judy C see the README.

For installation of Judy PECL visit here_.

.. _here: http://pecl.php.net/package/Judy

