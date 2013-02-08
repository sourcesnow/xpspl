<?php
namespace XPSPL\database;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

import('logger');

use \InvalidArgumentException;

/**
 * Processes
 *
 * A database of signal processes.
 * 
 * As of v0.3.0 processes no longer maintain a reference to a signal.
 *
 * @since v3.1.0
 *
 * Processes now use index based priority, extends the database and is 
 * registered into the XPSPL\database namespace.
 *
 * This eliminates the need for using an array for storage and should improve 
 * performance a bit ... but it needs measurements to prove that.
 *
 * When a process is installed and another process with identical priority 
 * exists the processes will be installed into their own database within the 
 * database registered with the given priority, once registered in the 
 * sub-database priority is based on FIFO.
 *
 * This allows only for a constant n+1 deep matrix.
 */
class Processes extends \XPSPL\Database {

    /**
     * Constructs a new Database.
     *
     * @return  void
     */
    public function __construct(/* ... */)
    {
        if (XPSPL_JUDY_SUPPORT) {
            $this->_storage = new \Judy(\Judy::INT_TO_MIXED);
        }
    }

    /**
     * Installs a new process into the database.
     *
     * @param  object  $process  \XPSPL\Process
     *
     * @return  void
     */
    public function install(\XPSPL\Process $process)
    {
        $process = clone $process;
        $priority = $process->get_priority();
        if (isset($this->_storage[$priority])) {
            if ($this->_storage[$priority] instanceof $this) {
                $process->set_priority(
                    $this->_storage[$priority]->end()->get_priority() + 1
                );
                $this->_storage[$priority]->install($process);
            } else {
                $this->_storage[$priority]->set_priority(0);
                $db = new Processes();
                $db->install($this->_storage[$priority]);
                unset($this->_storage[$priority]);
                $this->_storage[$priority] = $db;
                $this->install($process);
            }
        } else {
            $this->_storage[$priority] = $process;
        }
    }

    /**
     * Deletes a process from the database.
     *
     * @param  object  $process  \XPSPL\Process
     *
     * @return  boolean
     */
    public function delete(\XPSPL\Process $process)
    {
        if ($this->count() === 0) {
            return false;
        }
        // I dont like doing this in PHP ... array_search needs to implement 
        // a deep search
        reset($this->_storage);
        foreach ($this->_storage as $_key => $_node) {
            if ($_node instanceof Processes) {
                if ($_node->delete($process)) {
                    return true;
                }
            } else {
                if ($_node === $process) {
                    unset($this->_storage[$_key]);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Merges another Processes database into the current.
     *
     * @param  object  $processes  Processes
     *
     * @return  void
     */
    public function merge($array)
    {
        if (!$array instanceof Processes) {
            throw new \InvalidArgumentException;
        }
        foreach ($array->storage() as $_priority => $_process) {
            if ($_process instanceof Processes) {
                foreach ($_process->storage() as $_sub_process) {
                    $_sub_process->set_priority($_priority);
                    $this->install($_sub_process);
                }
            } else {
                $this->install($_process);
            }
        }
    }
}