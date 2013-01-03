<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
import('unittest');

unittest\suite(function(){

    $this->test(function(){
        $this->exception('InvalidArgumentException', function(){
            $process = new XPSPL\Handle(null);
        });
        $process = new XPSPL\Handle(function(){}, 'a');
        $this->equal($process->exhaustion(), 1);
        $process = new XPSPL\Handle(function(){}, -1);
        $this->equal($process->exhaustion(), 1);
    }, "process construction");

    $this->test(function(){
        $process = new XPSPL\Handle(function(){});
        $this->false($process->is_exhausted());
        $process->decrement_exhaust();
        $this->true($process->is_exhausted());
        $process = new XPSPL\Handle(function(){}, 2);
        $process->decrement_exhaust();
        $this->false($process->is_exhausted());
        $process->decrement_exhaust();
        $this->true($process->is_exhausted());
        $process = new XPSPL\Handle(function(){}, null);
        for ($i=0;$i!=5;$i++) { $process->decrement_exhaust(); }
        $this->false($process->is_exhausted());
        $process = new XPSPL\Handle(function(){}, 0);
        $this->true($process->is_exhausted());
    }, "Handle exhaustion");

});