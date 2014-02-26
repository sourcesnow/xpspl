<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use XPSPL\exception\Module_Load_Failure;

/**
 * Library
 *
 * Loads and tracks XPSPL modules.
 */
class Library extends Database {

    use Singleton;

    /**
     * Path(s) to XPSPL modules.
     *
     * @var  string
     */
    protected $_path = [];

    /**
     * Constructs the Library
     */
    public function __construct() {
        if (defined('XPSPL_MODULE_DIR')) {
            $this->add_path(XPSPL_MODULE_DIR);
        }
    }

    /**
     * Loads a XPSPL module.
     *
     * @param  string  $name  Module name.
     * @param  string|null  $dir  Location of the module.
     *
     * @return  void
     */
    public function load($name, $dir = null)
    {
        // already loaded
        if (isset($this->_storage[$name])) return;
        foreach ($this->_path as $_path) {
            $path = $_path.'/'.$name;
            if (!file_exists(sprintf('%s/__init__.php', $path))) {
                continue;
            }
            $this->_storage[$name] = true;
            require_once $path.'/__init__.php';
            if (!defined(strtoupper(sprintf('%s_version', $name)))) {
                throw new \RuntimeException(sprintf(
                    'Module %s does not specify a version path %s',
                    $name, $path
                ));
            }
        }
    }

    /**
     * Adds a new path where XPSPL modules are loaded from.
     *
     * @param  string  $path  Full path to directory
     *
     * @return  void
     */
    public function add_path($path)
    {
        if (!is_dir($path)) {
            throw new Module_Load_Failure(sprintf(
                "Module directory %s does not exist", $path
            ));
        }
        $this->_path[] = $path;
    }
}