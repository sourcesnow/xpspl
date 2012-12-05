<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
prggmr\load_module('unittest');

use prggmr\module\unittest as unittest;

unittest\suite(function(){

    $this->test(function(){
        $this->exception('InvalidArgumentException', function(){
            $handle = new prggmr\Handle(null);
        });
        $handle = new prggmr\Handle(function(){}, 'a');
        $this->equal($handle->exhaustion(), 1);
        $handle = new prggmr\Handle(function(){}, -1);
        $this->equal($handle->exhaustion(), 1);
    }, "handle construction");

    $this->test(function(){
        $a = null;
        $handle = new prggmr\Handle(function() use (&$a){
            $a = $this;
        });
        $handle();
        $this->instanceof(new \stdClass(), $a);
    }, "Handle binding");

    $this->test(function(){
        $handle = new prggmr\Handle(function(){});
        $this->false($handle->is_exhausted());
        $handle->decrement_exhaust();
        $this->true($handle->is_exhausted());
        $handle = new prggmr\Handle(function(){}, 2);
        $handle->decrement_exhaust();
        $this->false($handle->is_exhausted());
        $handle->decrement_exhaust();
        $this->true($handle->is_exhausted());
        $handle = new prggmr\Handle(function(){}, null);
        for ($i=0;$i!=5;$i++) { $handle->decrement_exhaust(); }
        $this->false($handle->is_exhausted());
        $handle = new prggmr\Handle(function(){}, 0);
        $this->true($handle->is_exhausted());
    }, "Handle exhaustion");

});