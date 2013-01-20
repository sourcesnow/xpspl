.. /processor/signal/error.php generated using docpx on 01/16/13 03:03am


XPSPL\processor\signal\Error
============================


The error event



Methods
-------

__construct
===========

.. function:: __construct([$error = false, [$exception = false]])


    Constructs a new signal.

    :param string $error: Error message.
    :param object|null $exception: Exception object if exists

    :rtype: void 



get_error
=========

.. function:: get_error()


    Returns the error message.

    :rtype: string 



get_exception
=============

.. function:: get_exception()


    Returns the exception, if set.

    :rtype: object|null 





