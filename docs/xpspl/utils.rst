.. utils.php generated using docpx on 01/27/13 03:54pm


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

.. function:: signal_exceptions()


    Transforms PHP exceptions into a signal.
    
    The signal fired is \XPSPL\processor\Signal::GLOBAL_EXCEPTION

    :param object: \Exception

    :rtype: void 



signal_errors
=============

.. function:: signal_errors()


    Transforms PHP errors into a signal.
    
    The signal fired is \XPSPL\processor\Signal::GLOBAL_ERROR

    :param int: 
    :param string: 
    :param string: 
    :param int: 

    :rtype: void 



bin_search
==========

.. function:: bin_search()


    Performs a binary search for the given node returning the index.
    
    Logic:
    
    0 - Match
    > 0 - Move backwards
    < 0 - Move forwards

    :param mixed: Needle
    :param array: Hackstack
    :param closure: Comparison function

    :rtype: null|integer index, null locate failure



get_class_name
==============

.. function:: get_class_name()


    Returns the name of a class using get_class with the namespaces stripped.
    This will not work inside a class scope as get_class() a workaround for
    that is using get_class_name(get_class());

    :param object|string: Object or Class Name to retrieve name

    :rtype: string Name of class with namespaces stripped



backtrace
=========

.. function:: backtrace()


    Wrapper for backtrace with/without args.

    :rtype: array 



XPSPL_AUTOLOADER
================

Autoloader

