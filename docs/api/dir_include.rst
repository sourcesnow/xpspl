.. /dir_include.php generated using docpx v1.0.0 on 03/03/14 10:55am


xp_dir_include
**************


.. function:: xp_dir_include($dir, [$listen = false, [$path = false]])


    Recursively includes all .php files in the given directory.
    
    Listeners can be started automatically by passing ``$listen`` as ``true``.
    
    .. note::
    
       Listener class names are generated compliant to PSR-4 with the directory
       serving as the top-level namespace.

    :param string: Directory to include.
    :param boolean: Start listeners.
    :param string: Path to ignore when starting listeners.

    :rtype: void 


Example #1 Basic Usage
######################

.. code-block:: php

    <?php

    xp_dir_include('Foo');

With the directory structure.

.. code-block:: php

    - Foo/
        - Bar.php

Will include the file Foo/Bar.php

Example #2 Listeners
####################

.. code-block:: php

    <?php

    xp_include_dir('Foo', true);

With the directory structure.

.. code-block:: php

    - Foo/
        - Bar.php
        - Bar/
            - Hello_World.php

Will include the files ``Foo/Bar.php, Foo/Bar/Hello_World.php`` and attempt
to start classes ``Foo\Bar, Foo\Bar\Hello_World``.

.. note::

    Listeners must extend the XPSPL\\Listener class.




Created on 03/03/14 10:55am using `Docpx <http://github.com/prggmr/docpx>`_