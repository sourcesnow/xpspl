<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Database
 * 
 * A signal database.
 *
 * All signals are stored in a database by their index.
 *
 * Each signal stored has a copy of the signal and it's queue.
 */
class Database {

    use Storage;

    /**
     * Finds the signal in the database.
     *
     * Returns null if the signal does not exit.
     *
     * @param  object  $signal  
     *
     * @return  object|
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