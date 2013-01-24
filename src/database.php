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
 * A signal database.
 *
 * All signals are stored in a database by their index.
 *
 * Each signal stored has a copy of the signal and it's queue.
 *
 * @experimental
 *
 * Judy is currently being experimented as a storage mechanism for performance 
 * improvements.
 *
 * To disable Judy support declare XPSPL_JUDY_SUPPORT false, otherwise support 
 * will be used if Judy is installed and enabled on the PHP installation.
 */
if (XPSPL_JUDY_SUPPORT){
class Database {

    use Storage;
    
    /**
     * Constructs a new Database.
     *
     * @return  void
     */
    public function __construct(/* ... */)
    {
        $this->_storage = new Judy(Judy::STRING_TO_MIXED);
    }

    /**
     * Finds the signal in the database.
     *
     * Returns null if the signal does not exit.
     *
     * @param  object  $signal  
     *
     * @return  object
     */
    public function find_signal(SIG $signal)
    {
        $index = $signal->get_index();
        if (isset($this->_storage[$index])) {
            return $this->_storage[$index];
        }
        return null;
    }

    /**
     * Registers a signal in the database with the given queue.
     *
     * @param  object  $signal \XPSPL\SIG
     * @param  object  $queue  \XPSPL\Queue
     *
     * @return  void
     */
    public function register_signal(SIG $signal, Queue $queue)
    {
        $index = $signal->get_index();
        $this->_storage[$index] = [$signal, $queue];
    }

    /**
     * Frees the database.
     */
    public function free(/* ... */)
    {
        $this->_storage->free();
    }
}
} else {
class Database {

    use Storage;

    /**
     * Finds the signal in the database.
     *
     * Returns null if the signal does not exit.
     *
     * @param  object  $signal  
     *
     * @return  object
     */
    public function find_signal(SIG $signal)
    {
        $index = $signal->get_index();
        if (isset($this->_storage[$index])) {
            return $this->_storage[$index];
        }
        return null;
    }

    /**
     * Registers a signal in the database with the given queue.
     *
     * @param  object  $signal \XPSPL\SIG
     * @param  object  $queue  \XPSPL\Queue
     *
     * @return  void
     */
    public function register_signal(SIG $signal, Queue $queue)
    {
        $index = $signal->get_index();
        $this->_storage[$index] = [$signal, $queue];
    }
}
}