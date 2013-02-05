<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \Judy;

/**
 * Database
 * 
 * A database is a storage mechanism for arbirtary data.
 *
 * @experimental
 *
 * Judy is currently being experimented as a storage mechanism for performance 
 * improvements.
 *
 * To disable Judy support declare XPSPL_JUDY_SUPPORT false, otherwise support 
 * will be used if Judy is installed and enabled on the PHP installation.
 */
class Database {

    use Storage;
    
    /**
     * Constructs a new Database.
     *
     * @return  void
     */
    public function __construct(/* ... */)
    {
        if (XPSPL_JUDY_SUPPORT) {
            $this->_storage = new Judy(Judy::STRING_TO_MIXED);
        }
    }

    /**
     * Frees the database.
     */
    public function free(/* ... */)
    {
        if (XPSPL_JUDY_SUPPORT) {
            $this->_storage->free();
        } else {
            unset($this->_storage);
            $this->_storage = [];
        }
    }

    /**
     * Access the last node in the database.
     * 
     * @return  Node at end of database
     */
    public function end(/* ... */)
    {
        if (XPSPL_JUDY_SUPPORT) {
            return $this->_storage[
                $this->_storage->byCount($this->_storage->count())
            ];
        } else {
            return end($this->_storage);
        }
    }
}
