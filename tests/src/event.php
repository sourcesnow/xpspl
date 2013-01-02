<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
import('unittest');

unittest\suite(function(){

    $this->setup(function(){
        $this->event = new XPSPL\Event();
    });

    $this->teardown(function(){
        unset($this->event);
    });

    $this->test(function(){
        $this->event->set_result(true);
        $this->true($this->event->get_result());
        $this->event->set_result(false);
        $this->false($this->event->get_result());
    }, "event_result");

    $this->test(function(){
        $this->equal($this->event->get_state(), STATE_DECLARED);
        $this->event->halt();
        $this->equal($this->event->get_state(), STATE_HALTED);
    }, "event_halt");

    $this->test(function(){
        $parent = new XPSPL\Event();
        $this->false($this->event->is_child());
        $this->event->set_parent($parent);
        $this->true($this->event->is_child());
        $this->equal($this->event->get_parent(), $parent);
        $this->event->set_parent($this->event);
        $this->equal($this->event->get_parent(), $this->event);
    }, "event_parent_child");

    $this->test(function(){
        $this->exception('LogicException', function(){
            $this->event->a++;
        });
        $this->event->a = "Test";
        $this->true(isset($this->event->a));
        $this->equal($this->event->a, "Test");
        unset($this->event->a);
        $this->false(isset($this->event->a));
        $this->exception('LogicException', function(){
            $this->event->a++;
        });
    }, "event_data");
    
});