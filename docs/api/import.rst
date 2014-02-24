.. /import.php generated using docpx v1.0.0 on 02/22/14 06:39pm


xp_import
*********


.. function:: xp_import()


    Import a module for usage.

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
	 * Import a module for usage.
	 *
	 * @param  string  $name  Module name.
	 * @param  string|null  $dir  Location of the module.
	 *
	 * @return  void
	 */
	function xp_import($name, $dir = null)
	{
	    return \XPSPL\Library::instance()->load($name, $dir);
	}

Created on 02/22/14 06:39pm using `Docpx <http://github.com/prggmr/docpx>`_