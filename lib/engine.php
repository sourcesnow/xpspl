<?php
namespace prggmr;
/**
 *  Copyright 2010 Nickolas Whiting
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 *
 * @author  Nickolas Whiting  <me@nwhiting.com>
 * @package  prggmr
 * @copyright  Copyright (c), 2010 Nickolas Whiting
 */


use \Closure,
    \InvalidArgumentException;

/**
 * As of v0.1.2 the engine uses 2 different storages, indexed and non-indexed
 * for performance. Indexable signals (integers and strings) are placed in
 * the indexed storage and allow for index based lookups, non-indexable
 * signals (objects, floats, booleans, arrays and non-indexable Signal objects)
 * are placed in the non-indexed storage and require loop through lookups.
 */
class Engine {

    /**
     * An indexed storage of Queues.
     *
     * @var  array
     */
    public $_indexStorage = null;

    /**
     * A non index storage of Queue
     *
     * @var  array
     */
    public $_storage = null;

    /**
     * Construction inits our empty storage array.
     *
     * @return  void
     */
    public function __construct(/* ... */)
    {
        $this->_storage = array();
    }

    /**
     * Attaches a new subscription to a signal queue.
     *
     * @param  mixed  $signal  Signal the subscription will attach to, this
     *         can be a Signal object, the signal representation or an array
     *         for a chained signal.
     *
     * @param  mixed  $subscription  Subscription closure that will trigger on
     *         fire or a Subscription object.
     *
     * @param  string  $identifier  String identifier of this subscription.
     *
     * @param  integer $priority  Priority of the subscription
     *
     * @param  mixed  $chain  Chain signal
     *
     * @param  integer  $exhaust  Count to set subscription exhaustion.
     *
     * @throws  InvalidArgumentException  Thrown when an invalid callback is
     *          provided.
     *
     * @return  void
     */
    public function subscribe($signal, $subscription, $identifier = null, $priority = null, $chain = null, $exhaust = 0)
    {
        if (!$subscription instanceof Subscription) {
            if (!is_callable($subscription)) {
                throw new \InvalidArgumentException(
                    'subscription callback is not a valid callback'
                );
            }
            $subscription = new Subscription($subscription, $identifier, $exhaust);
        }

		$queue = $this->queue($signal);
		$queue->enqueue($subscription, $priority);

		if (null !== $chain) {
			$queue->getSignal()->setChain($chain);
		}

        return $queue;
    }

	/**
    * Removes a subscription from the queue.
    *
    * @param  mixed  $signal  Signal the subscription is attached to, this
     *         can be a Signal object or the signal representation.
    *
    * @param  mixed  subscription  String identifier of the subscription or
    *         a Subscription object.
    *
    * @throws  InvalidArgumentException
    * @return  void
    */
    public function dequeue($signal, $subscription)
    {
		$queue = $this->queue($signal, false);
		if (false === $queue) return false;
		return $queue->dequeue($subscription);
	}

    /**
     * Locates a Queue object in storage, if not found one is created.
     *
     * @param  mixed  $signal  Signal the queue represents.
     * @param  boolean  $generate  Generate the queue if not found.
     *
     * @return  mixed  Queue object, false if generate is false and queue
     *          is not found.
     */
    public function queue($signal, $generate = true)
    {
        $obj = (is_object($signal) && $signal instanceof Signal);
        $indexable = false;
        if (static::canIndex($signal)) {
            $index = ($obj) ? $signal->signal() : $signal;
            if (isset($this->_indexStorage[$index])) {
                return $this->_indexStorage[$index];
            }
            $indexable = true;
        } else {
            $length = count($this->_storage);
            for($i=0;$i!=$length;$i++) {
                if (($obj && $this->_storage[$i]->getSignal() === $signal) ||
                ($this->_storage[$i]->getSignal(true) === $signal)) {
                    return $this->_storage[$i];
                }
            }
        }

		if (!$generate) return false;

        if (!(is_object($signal) && $signal instanceof Signal)) {
            $signal = new Signal($signal);
        }

        $queue = new Queue($signal);

        // new queue
        if ($indexable) {
            $this->_indexStorage[$index] = $queue;
        } else {
            $this->_storage[] = $queue;
        }
        return $queue;
    }

    /**
     * Fires an event signal.
     *
     * @param  mixed  $signal  The event signal, this can be the signal object
     *         or the signal representation.
     *
     * @param  array  $vars  Array of variables to pass the subscribers
     *
     * @param  object  $event  Event
     *
     * @return  object  Event
     */
    public function fire($signal, $vars = null, $event = null)
    {
        $queue = false;
        // extra vars returned from a signal compare
        $compare = false;
		// index lookup
        if (static::canIndex($signal)) {
            $index = ($obj) ? $signal->getSignal() : $signal;
            if (isset($this->_indexStorage[$index])) {
                $queue = $this->_indexStorage[$index];
            }
        }
        // non-index lookup - this is done on all signals
        // if an indexed signal is not found
        if (false === $queue) {
            $length = count($this->_storage);
            for($i=0;$i!=$length;$i++) {
                if (false !== ($compare = $this->_storage[$i]->getSignal()->compare($signal))) {
                    $queue = $this->_storage[$i];
                    break;
                }
            }
        }

        if (!$queue) return false;

		if (null !== $vars) {
			if (!is_array($vars)) {
				$vars = array($vars);
			}
		}

		// rewinds and prioritizes the queue
        $queue->rewind();

        if (!is_object($event)) {
            $event = new Event();
        } elseif (!$event instanceof Event) {
            throw new \InvalidArgumentException(
                sprintf(
                    'fire expected instance of Event recieved "%s"'
                , get_class($event))
            );
        }

        $event->setSignal($queue->getSignal());
        $event->setState(Event::STATE_ACTIVE);

        if (0 === count($vars)) {
            $vars = array(&$event);
        } else {
            $vars = array_merge(array(&$event), $vars);
        }

        if ($compare !== false) {
            // allow for array return
            if (is_array($compare)) {
                $vars = array_merge($vars, $compare);
            } else {
                $vars[] = $compare;
            }
        }

		// the queue loop
        while($queue->valid()) {
            if ($event->isHalted()) break;
            $queue->current()->fire($vars);
            if ($event->getState() == Event::STATE_ERROR) {
                throw new \RuntimeException(
                    sprintf(
                        'Event execution failed with message "%s"',
                        $event->getStateMessage()
                    )
                );
            }
			if ($queue->current()->isExhausted()) {
				$queue->dequeue($queue->current());
			}
            $queue->next();
        }

        // the chain
        if (null !== ($chain = $queue->getSignal()->getChain())) {
            if (null !== ($data = $event->getData())) {
                // remove the current event from the vars
                unset($vars[0]);
                $vars = array_merge($vars, $event->getData());
            }
            foreach ($chain as $_chain) {
                $link = $this->fire($_chain, $vars);
                if (false !== $chain) {
                    $event->setChain($link);
                }
            }
        }

        // keep the event in an active state until its chain completes
        $event->setState(Event::STATE_INACTIVE);

        return $event;
    }

    /**
     * Flushes the engine.
     */
    public function flush(/* ... */)
    {
        $this->_storage = array();
        $this->_indexStorage = array();
    }

    /**
     * Returns the count of subsciption queues in the engine.
     *
     * @return  integer
     */
    public function count()
    {
        return count($this->_storage) + count($this->_indexStorage);
    }

    /**
     * Returns if the provided param is indexable in a php array.
     *
     * @param  mixed  $param
     *
     * @return  boolean
     */
    public static function canIndex($param)
    {
        if (is_object($param) && $param instanceof Signal) {
            return $param->canIndex();
        }
        return is_int($param) || is_string($param);
    }
}