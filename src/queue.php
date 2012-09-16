<?php
namespace prggmr;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \InvalidArgumentException;

/**
 * Defines the maximum number of handlers allowed within a Queue.
 */
if (!defined('QUEUE_MAX_SIZE')) {
    define('QUEUE_MAX_SIZE', 24);
}

/**
 * Defines the default priority of queue nodes
 */
if (!defined('QUEUE_DEFAULT_PRIORITY')) {
    define('QUEUE_DEFAULT_PRIORITY', 100);
}

/**
 * As of v0.3.0 Queues no longer maintain a reference to a signal.
 *
 * The Queue is still a representation of a PriorityQueue and will remain so 
 * until the issues with PHP's current implementation are addressed.
 * 
 * The queue can also be explicity set to a MIN or MAX heap upon construction.
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
     * Heap type.
     * 
     * @var  integer
     */
    protected $_type = 0;

    /**
     * Priority
     */
    protected $_priority = QUEUE_DEFAULT_PRIORITY;

    /**
     * Pushes a new handler into the queue.
     *
     * @param  mixed  $node  Variable to store
     * @param  integer $priority  Priority of the callable
     *
     * @throws  OverflowException  If max size exceeded
     *
     * @return  void
     */
    public function enqueue($node, $priority = null)
    {
        if ($this->count() > QUEUE_MAX_SIZE) {
            throw new \OverflowException(
                'Queue max size reached'
            );
        }
        $this->_dirty = true;
        if (null === $priority || !is_int($priority)) {
            $priority = $this->_priority;
        }
        $this->_priority++;
        $this->_storage[] = [$node, $priority];
    }

    /**
    * Removes a handle from the queue.
    *
    * @param  mixed  $node  Reference to the node.
    *
    * @throws  InvalidArgumentException
    * @return  boolean
    */
    public function dequeue($node)
    {
        if ($this->count() === 0) return false;
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