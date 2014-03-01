.. /dir_include.php generated using docpx v1.0.0 on 02/28/14 07:47pm


xp_dir_include
**************


.. function:: xp_dir_include($dir, [$listen = false, [$path = false]])


    Recursively includes all .php files with the option to start a listener
    automatically after including the file.
    
    .. note::
    
       When autostarting listeners the class name is expected in PSR-0 compliant.
    
       The ``$dir`` serves as the initial namespace for class listeners.
    
       For example ``xp_dir_include('Foobar', true);`` will load all files
       contained in the Foobar directory, with a file named ``test.php`` it
       will expect a class ``Foobar\Test`` which extends the ``XPSPL\Listener``
       object.

    :param string: Directory to include.
    :param boolean: Start listeners.
    :param string: Path to ignore when starting listeners.

    :rtype: void 





