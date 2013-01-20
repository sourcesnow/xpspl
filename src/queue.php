<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \InvalidArgumentException;

/**
 * Queue
 *
 * A database of signal processes.
 * 
 * As of v0.3.0 Queues no longer maintain a reference to a signal.
 *
 * The Queue is still a representation of a PriorityQueue and will remain so 
 * until the issues with PHP's current implementation are addressed.
 */
class Queue {

    use Storage;

    /**
     * Flag for prioritizing.
     * 
     * @var  boolean
     */
    protected $_dirty = false;

    /**
     * Priority
     */
    protected $_priority = PROCESS_DEFAULT_PRIORITY;

    /**
     * Pushes a new process into the queue.
     *
     * @param  mixed  $node  Variable to store
     * @param  integer $priority  Priority of the callable
     *
     * @return  void
     */
    public function enqueue($node, $priority = null)
    {
        $this->_dirty = true;
        if (null === $priority || !is_int($priority)) {
            $priority = $this->_priority;
        }
        $this->_priority++;
        $this->_storage[] = [$node, $priority];
    }

    /**
    * Removes a process from the queue.
    *
    * @param  mixed  $node  Reference to the node.
    *
    * @throws  InvalidArgumentException
    * @return  boolean
    */
    public function dequeue($node)
    {
        if ($this->count() === 0) {
            return false;
        }
        reset($this->_storage);
        foreach ($this->_storage as $_key => $_node) {
            if ($_node[0] === $node) {
                unset($this->_storage[$_key]);
                return true;
            }
        }
        return false;
    }

    /**
     * Sorts the queue.
     *
     * @return  void
     */
    public function sort()
    {
        if (!$this->_dirty) return null;
        usort($this->_storage, function($a, $b){
            $a = $a[1];
            $b = $b[1];
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });
        $this->_dirty = false;
    }
}