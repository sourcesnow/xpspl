<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Import a module for usage.
 *
 * By default modules will be loaded from the ``modules/`` directory located
 * within XPSPL.
 *
 * @param  string  $name  Module name.
 * @param  string|null  $dir  Location of the module.
 *
 * @return  void
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     // Import the time module
 *     xp_import('time');
 *
 * @example
 *
 * Example #2 Importing modules from user-defined directories
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     // Import the "foobar" module from our custom module directory
 *     xp_import('foobar', '/my-custom/directory/path');
 */
function xp_import($name, $dir = null)
{
    return \XPSPL\Library::instance()->load($name, $dir);
}