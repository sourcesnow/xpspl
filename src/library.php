<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use processor\signal\Module_Load_Failure,
    processor\event\Error;

/**
 * Library
 * 
 * Loads and tracks XPSPL modules.
 */
class Library {

    use Storage, Singleton;

    /**
     * Loads a XPSPL module.
     * 
     * @param  string  $name  Module name.
     * @param  string|null  $dir  Location of the module. 
     * 
     * @return  boolean
     */
    public function load($name, $dir = null) 
    {
        // already loaded
        if (isset($this->_storage[$name])) return true;
        if ($dir === null) {
            $dir = XPSPL_MODULE_DIR;
        } else {
            if (!is_dir($dir)) {
                emit(new Module_Load_Failure(),  new Error(sprintf(
                    "Module directory %s does not exist", $dir
                )));
            }
        }
        if (is_dir($dir.'/'.$name)) {
            $path = $dir.'/'.$name;
            if (file_exists($path.'/__autoload.php')) {
                // keep history of what has been loaded
                $this->_storage[$name] = true;
                require $path.'/__autoload.php';
            } else {
                emit(new Module_Load_Failure(), new Error(
                    "Module does not have an __autoload file"
                ));
            }
        } else {
            emit(new Module_Load_Failure(), new Error(sprintf(
                "Module %s does not exist", $name
            )));
        }
        return true;
    }
}