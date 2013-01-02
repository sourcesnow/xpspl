<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
import('unittest');

unittest\suite(function(){

    $this->setup(function(){
        $this->signal = new XPSPL\Signal();
    });

    $this->teardown(function(){
        unset($this->signal);
    });

    $this->test(function(){
        $this->signal->set_result(true);
        $this->true($this->signal->get_result());
        $this->signal->set_result(false);
        $this->false($this->signal->get_result());
    }, "signal_result");

    $this->test(function(){
        $this->equal($this->signal->get_state(), STATE_DECLARED);
        $this->signal->halt();
        $this->equal($this->signal->get_state(), STATE_HALTED);
    }, "signal_halt");

    $this->test(function(){
        $parent = new XPSPL\Event();
        $this->false($this->signal->is_child());
        $this->signal->set_parent($parent);
        $this->true($this->signal->is_child());
        $this->equal($this->signal->get_parent(), $parent);
        $this->signal->set_parent($this->signal);
        $this->equal($this->signal->get_parent(), $this->signal);
    }, "signal_parent_child");

    $this->test(function(){
        $this->exception('LogicException', function(){
            $this->signal->a++;
        });
        $this->signal->a = "Test";
        $this->true(isset($this->signal->a));
        $this->equal($this->signal->a, "Test");
        unset($this->signal->a);
        $this->false(isset($this->signal->a));
        $this->exception('LogicException', function(){
            $this->signal->a++;
        });
    }, "signal_data");
    
});