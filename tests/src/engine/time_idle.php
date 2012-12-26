<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

load_module('unittest');

unittest\suite(function(){

    $this->test(function(){
        $time1 = new \xpspl\engine\idle\Time(1, \xpspl\engine\idle\Time::SECONDS);
        $time2 = new \xpspl\engine\idle\Time(1500, \xpspl\engine\idle\Time::MILLISECONDS);
        $this->true($time1->override($time2));
    }, 'Milliseconds more than seconds');

    $this->test(function(){
        $time1 = new \xpspl\engine\idle\Time(2, \xpspl\engine\idle\Time::SECONDS);
        $time2 = new \xpspl\engine\idle\Time(1500, \xpspl\engine\idle\Time::MILLISECONDS);
        $this->true($time1->override($time2));
    }, 'Seconds more than milliseconds');

});