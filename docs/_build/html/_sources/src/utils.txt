.. /utils.php generated using docpx on 01/16/13 03:03am


XPSPL_AUTOLOADER
================

Autoloader

$class
======

.. function:: $class()



milliseconds
============

.. function:: milliseconds()


    Returns the current time since epox in milliseconds.

    :rtype: integer 



microseconds
============

.. function:: microseconds()


    Returns the current time since epox in microseonds.

    :rtype: integer 



signal_exceptions
=================

.. function:: signal_exceptions($exception)


    Transforms PHP exceptions into a signal.
    
    The signal fired is \XPSPL\processor\Signal::GLOBAL_EXCEPTION

    :param object $exception: \Exception

    :rtype: void 



signal_errors
=============

.. function:: signal_errors($errno, $errstr, $errfile, $errline)


    Transforms PHP errors into a signal.
    
    The signal fired is \XPSPL\processor\Signal::GLOBAL_ERROR

    :param int $errno: 
    :param string $errstr: 
    :param string $errfile: 
    :param int $errline: 

    :rtype: void 



bin_search
==========

.. function:: bin_search($needle, $haystack, [$compare = false])


    Performs a binary search for the given node returning the index.
    
    Logic:
    
    0 - Match
    > 0 - Move backwards
    < 0 - Move forwards

    :param mixed $needle: Needle
    :param array $haystack: Hackstack
    :param closure $compare: Comparison function

    :rtype: null|integer index, null locate failure



$node
=====

.. function:: $node()



get_class_name
==============

.. function:: get_class_name([$object = false])


    Returns the name of a class using get_class with the namespaces stripped.
    This will not work inside a class scope as get_class() a workaround for
    that is using get_class_name(get_class());

    :param object|string $object: Object or Class Name to retrieve name

    :rtype: string Name of class with namespaces stripped



