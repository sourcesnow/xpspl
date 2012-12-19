<?php
namespace prggmr;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use engine\signal\Module_Load_Failure,
    engine\event\Error;

/**
 * Library
 * 
 * Loads and tracks prggmr modules.
 */
class Library {

    use Storage, Singleton;

    /**
     * Loads a library module.
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
            $dir = PRGGMR_MODULE_DIR;
        } else {
            if (!is_dir($dir)) {
                signal(new Module_Load_Failure(),  new engine\event\Error(
                    "Module directory %s does not exist", $dir
                ));
            }
        }
        if (is_dir($dir.'/'.$name)) {
            $path = $dir.'/'.$name;
            if (file_exists($path.'/__autoload.php')) {
                // keep history of what has been loaded
                $this->_storage[$name] = true;
                require $path.'/__autoload.php';
            } else {
                $this->signal(new engine_signals\Signal_Library_Failure(
                    "Module does not have an __autoload file"
                ),  new engine\event\Error([$name, $dir]));
            }
        } else {
            $this->signal(new engine_signals\Signal_Library_Failure(sprintf(
                "Module %s does not exist", $name
            )), new engine\event\Error());
        }
        return true;
    }
}