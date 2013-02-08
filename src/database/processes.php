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
 * Priority database for signal processes.
 * 
 * @since v0.3.0 
 * 
 * Processes no longer maintain a reference to a signal.
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
 * exists the processes will be installed into a sub-database the index 
 * priority is then based on FIFO.
 *
 * This allows only for a constant n+1 scale without sort.
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
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                '%s process install',
                spl_object_hash($process)
            ));
        }
        $priority = $process->get_priority();
        if ($this->offsetExists($priority)) {
            if ($this->offsetGet($priority) instanceof Processes) {
                if (XPSPL_DEBUG) {
                    logger(XPSPL_LOG)->debug(sprintf(
                        '%s sub-database fifo',
                        spl_object_hash($this->offsetGet($priority))
                    ));
                    logger(XPSPL_LOG)->debug(sprintf(
                        '%s last node',
                        spl_object_hash($this->offsetGet($priority))
                    ));
                    logger(XPSPL_LOG)->debug(sprintf(
                        '%s next priority',
                        $this->offsetGet($priority)->end()->get_priority()
                    ));
                }
                $process->set_priority(
                    $this->offsetGet($priority)->end()->get_priority() + 1
                );
                $this->_storage[$priority]->install($process);
            } else {
                if (XPSPL_DEBUG) {
                    logger(XPSPL_LOG)->debug(sprintf(
                        '%s create sub-database',
                        spl_object_hash($this->offsetGet($priority))
                    ));
                }
                $this->_storage[$priority]->set_priority(0);
                $db = new Processes();
                $db->install($this->_storage[$priority]);
                unset($this->_storage[$priority]);
                $this->_storage[$priority] = $db;
                $this->install($process);
            }
        } else {
            if (XPSPL_DEBUG) {
                logger(XPSPL_LOG)->debug(sprintf(
                    '%s installation',
                    spl_object_hash($process)
                ));
            }
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
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                '%s process delete',
                spl_object_hash($process)
            ));
        }
        if ($this->count() === 0) {
            return false;
        }
        // I dont like doing this in PHP ... 
        // array_search needs to implement a deep search
        $this->reset();
        foreach ($this as $_key => $_node) {
            if ($_node instanceof Processes) {
                if ($_node->delete($process)) {
                    return true;
                }
            } else {
                if ($_node === $process) {
                    $this->offsetUnset($_key);
                    if (XPSPL_DEBUG) {
                        logger(XPSPL_LOG)->debug(sprintf(
                            '%s deleted',
                            spl_object_hash($process)
                        ));
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Merges two Processes database together.
     *
     * The merged into database (self) takes precedence of the merged in 
     * database in FIFO.
     *
     * @param  object  $processes  \XPSPL\database\Processes
     *
     * @return  void
     */
    public function merge($array)
    {
        // ....
        if (!$array instanceof Processes) {
            throw new \InvalidArgumentException(sprintf(
                'Instanceof \XPSPL\database\Processes required recieved %s',
                (is_object($array)) ? get_class($array) : gettype($array)
            ));
        }
        foreach ($array as $_priority => $_process) {
            if ($_process instanceof Processes) {
                foreach ($_process as $_sub_process) {
                    $_sub_process->set_priority($_priority);
                    $_sub_process->set_exhaust(1);
                    $this->install($_sub_process);

                }
            } else {
                if (XPSPL_DEBUG) {
                        logger(XPSPL_LOG)->debug(sprintf(
                            '%s merged',
                            spl_object_hash($_process)
                        ));
                    }
                $this->install($_process);
            }
        }
    }
}