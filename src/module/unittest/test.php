<?php
namespace prggmr\module\unittest;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Unit testing signal
 * 
 * This allows for unit testing using signals.
 * 
 * Testing is performed as:
 * 
 * prggmr\module\unit_test\api\test(function(){
 *     $this->true(true);
 *     $this->false(false);
 *     $this->null(null);
 *     etc ...
 * });
 */
class Test extends \prggmr\signal\Complex {

    /**
     * Constructs a new test signal.
     * 
     * @param  string  $name  Name of the test.
     * @param  object  $event  prggmr\module\unittest\Event
     * 
     * @return  void
     */
    public function __construct($info = null, $event = null)
    {
        if (null !== $event && $event instanceof Event) {
            $this->_event = $event;
        } else {
            $this->_event = new Event();
        }
        $this->_info = $info;
        parent::__construct();
    }

    /**
     * Routine calculation.
     */
    public function routine($event_history = null)
    {
        $this->signal_this($this->_event);
        // test signals always return to fire immediatly
        return true;
    }

    /**
     * Evalute.
     */
    public function evaluate($signal = null)
    {
        if ($signal instanceof $this) return true;
        return false;
    }
}