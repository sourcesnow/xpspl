<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Recursively includes all .php files in the given directory.
 *
 * Listeners can be started automatically by passing ``$listen`` as ``true``.
 *
 * @param  string  $dir  Directory to include.
 * 
 * @param  boolean  $listen  Start listeners.
 * 
 * @param  string  $path  Path to ignore when starting listeners.
 *
 * @return  void
 *
 * .. note::
 *
 *    Listener class names are generated compliant to PSR-4 with the directory
 *    serving as the top-level namespace.
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block:: php
 *
 *     xp_dir_include('Foo');
 *
 * With the directory structure.
 * 
 * .. code-block:: php
 *
 *     - Foo/
 *         - Bar.php
 *
 * Will include the file Foo/Bar.php
 *
 * @example
 *
 * Example #2 Listeners
 *
 * .. code-block:: php
 *
 *     xp_include_dir('Foo', true);
 *
 * With the directory structure.
 * 
 * .. code-block:: php
 *
 *     - Foo/
 *         - Bar.php
 *         - Bar/
 *             - Hello_World.php
 *
 * Will include the files ``Foo/Bar.php, Foo/Bar/Hello_World.php`` and attempt 
 * to start classes ``Foo\Bar, Foo\Bar\Hello_World``.
 *
 * .. note::
 *
 *     Listeners must extend the XPSPL\\Listener class.
 *
 * .. code-block:: php
 *
 *     <?php
 *     namespace Foo\Bar;
 *
 *     Class Hello_World extends \XPSPL\Listener {
 *
 *         // Do something on the 'foo' signal
 *         public function on_foo(\XPSPL\SIG $signal) {
 *             echo 'foobar';
 *         }
 *         
 *     }
 *
 * When the ``XP_SIG('foo')`` signal is emitted the ``Hello_World->on_foo`` 
 * method will be executed.
 *
 */
function xp_dir_include($dir, $listen = false, $path = null)
{
    /**
     * This is some pretty narly code but so far the fastest I have been able
     * to get this to run.
     */
    $iterator = new \RegexIterator(
        new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir)
        ), '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH
    );
    foreach ($iterator as $_file) {
        array_map(function($i) use ($path, $listen){
            include $i;
            if (!$listen) {
                return false;
            }
            $process = sprintf(
                '%s\\%s',
                // Namespace
                implode('\\', array_pop(explode(
                    (WINDOWS) ? '\\' : '/',
                    str_replace([$path, '.php'], '', $i)
                ))),
                $class
            );
            if (class_exists($process, false) &&
                is_subclass_of($process, '\XPSPL\Listener')) {
                xp_listen(new $process());
            }
        }, $_file);
    }
}