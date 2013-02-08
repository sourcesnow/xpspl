<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
import('unittest');

unittest\suite(function($suite){

    $suite->setup(function($test){
        $test->signal = new XPSPL\Signal();
    });

    $suite->teardown(function($test){
        unset($test->signal);
    });

    $suite->test(function($test){
        $test->signal->set_result(true);
        $test->true($test->signal->get_result());
        $test->signal->set_result(false);
        $test->false($test->signal->get_result());
    }, "signal_result");

    $suite->test(function($test){
        $test->equal($test->signal->get_state(), STATE_DECLARED);
        $test->signal->halt();
        $test->equal($test->signal->get_state(), STATE_HALTED);
    }, "signal_halt");

    $suite->test(function($test){
        $parent = new XPSPL\Event();
        $test->false($test->signal->is_child());
        $test->signal->set_parent($parent);
        $test->true($test->signal->is_child());
        $test->equal($test->signal->get_parent(), $parent);
        $test->signal->set_parent($test->signal);
        $test->equal($test->signal->get_parent(), $test->signal);
    }, "signal_parent_child");

    $suite->test(function($test){
        $test->exception('LogicException', function(){
            $test->signal->a++;
        });
        $test->signal->a = "Test";
        $test->true(isset($test->signal->a));
        $test->equal($test->signal->a, "Test");
        unset($test->signal->a);
        $test->false(isset($test->signal->a));
        $test->exception('LogicException', function(){
            $test->signal->a++;
        });
    }, "signal_data");
    
});