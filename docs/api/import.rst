.. /import.php generated using docpx v1.0.0 on 04/23/14 12:10pm


xp_import
*********


.. function:: xp_import($name, [$dir = false])


    Import a module for usage.
    
    By default modules will be loaded from the ``modules/`` directory located
    within XPSPL.

    :param string: Module name.
    :param string|null: Location of the module.

    :rtype: void 


Example #1 Basic Usage
######################

.. code-block:: php

    <?php

    // Import the time module
    xp_import('time');

Example #2 Importing modules from user-defined directories
##########################################################

.. code-block:: php

    <?php

    // Import the "foobar" module from our custom module directory
    xp_import('foobar', '/my-custom/directory/path');





