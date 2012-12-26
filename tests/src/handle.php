<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
load_module('unittest');

unittest\suite(function(){

    $this->test(function(){
        $this->exception('InvalidArgumentException', function(){
            $handle = new xpspl\Handle(null);
        });
        $handle = new xpspl\Handle(function(){}, 'a');
        $this->equal($handle->exhaustion(), 1);
        $handle = new xpspl\Handle(function(){}, -1);
        $this->equal($handle->exhaustion(), 1);
    }, "handle construction");

    $this->test(function(){
        $handle = new xpspl\Handle(function(){});
        $this->false($handle->is_exhausted());
        $handle->decrement_exhaust();
        $this->true($handle->is_exhausted());
        $handle = new xpspl\Handle(function(){}, 2);
        $handle->decrement_exhaust();
        $this->false($handle->is_exhausted());
        $handle->decrement_exhaust();
        $this->true($handle->is_exhausted());
        $handle = new xpspl\Handle(function(){}, null);
        for ($i=0;$i!=5;$i++) { $handle->decrement_exhaust(); }
        $this->false($handle->is_exhausted());
        $handle = new xpspl\Handle(function(){}, 0);
        $this->true($handle->is_exhausted());
    }, "Handle exhaustion");

});