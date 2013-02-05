<?php
namespace XPSPL\database;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Signal Database
 * 
 * A database of signals.
 *
 * All signals are stored in a database by their index.
 *
 * Each signal stored has a copy of the signal and it's process database.
 */
class Signals extends \XPSPL\Database {

    /**
     * Finds the signal in the database.
     *
     * Returns null if the signal does not exit.
     *
     * @param  object  $signal  
     *
     * @return  object
     */
    public function find_signal(\XPSPL\SIG $signal)
    {
        $index = $signal->get_index();
        if (isset($this->_storage[$index])) {
            return $this->_storage[$index];
        }
        return null;
    }

    /**
     * Registers a signal in the database with the given processes database.
     *
     * @param  object  $signal \XPSPL\SIG
     * @param  object  $queue  \XPSPL\database\Processes
     *
     * @return  void
     */
    public function register_signal(\XPSPL\SIG $signal, Processes $database)
    {
        $index = $signal->get_index();
        $this->_storage[$index] = [$signal, $database];
    }
}