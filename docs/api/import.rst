.. /import.php generated using Docpx v1.0.0 on 01/13/14 04:39pm


Function - import
*****************


.. function:: import($name, [$dir = false])


    Import a module.

    :param string: Module name.
    :param string|null: Location of the module.

    :rtype: void 



import
======
PHP File @ /import.php

.. code-block:: php

	<?php
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Import a module.
	 * 
	 * @param  string  $name  Module name.
	 * @param  string|null  $dir  Location of the module. 
	 * 
	 * @return  void
	 */
	function import($name, $dir = null) 
	{
	    return \XPSPL\Library::instance()->load($name, $dir);
	}

Last updated on 01/13/14 04:39pm