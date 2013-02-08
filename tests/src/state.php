<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
import('unittest');

// tmp class for state test
class Temp {
    use XPSPL\State;
}

unittest\suite(function($suite){
    /**
     * Setup and teardown function
     */
    $suite->setup(function($test){
        $test->state = new Temp();
    });
    $suite->teardown(function($test){
        $test->state = null;
    });

    $suite->test(function($test){
        $test->equal($test->state->get_state(), STATE_DECLARED);
    }, 'Test default state');

});