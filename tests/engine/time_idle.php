<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
prggmr\load_signal('unittest');

use prggmr\signal\unittest as unittest;

unittest\generate_output();

unittest\suite(function(){

    unittest\test(function(){
        $time1 = new \prggmr\engine\idle\Time(1, \prggmr\engine\idle\Time::SECONDS);
        $time2 = new \prggmr\engine\idle\Time(1500, \prggmr\engine\idle\Time::MILLISECONDS);
        $this->false($time1->override($time2));
    }, 'Milliseconds more than seconds');

    unittest\test(function(){
        $time1 = new \prggmr\engine\idle\Time(2, \prggmr\engine\idle\Time::SECONDS);
        $time2 = new \prggmr\engine\idle\Time(1500, \prggmr\engine\idle\Time::MILLISECONDS);
        $this->true($time1->override($time2));
    }, 'Seconds more than milliseconds');

    unittest\test(function(){
        $time1 = new \prggmr\engine\idle\Time(1500, \prggmr\engine\idle\Time::MICROSECONDS);
        $time2 = new \prggmr\engine\idle\Time(1.6, \prggmr\engine\idle\Time::MILLISECONDS);
        $this->false($time1->override($time2));
    }, 'Microseconds less than milliseconds presicion');

});