<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
import('unittest');

unittest\suite(function($suite){

    $suite->test(function($test){
        $queue = new XPSPL\Queue();
        $queue->enqueue(0);
        $test->equal($queue->count(), 1);
    }, "Queue Enqueue");

    $suite->test(function($test){
        $queue = new XPSPL\Queue();
        $queue->enqueue(0);
        $queue->enqueue(1);
        $test->equal($queue->count(), 2);
        $queue->dequeue(0);
        $test->equal($queue->count(), 1);
    }, 'Queue Dequeue');

    $suite->test(function($test){
        $test->exception('OverflowException', function(){
            $queue = new XPSPL\Queue();
            for ($i=0;$i!=QUEUE_MAX_SIZE+5;$i++) {
                $queue->enqueue(0);
            }
        });
    }, "Queue Max Size Overflow exception");

    $suite->test(function($test){
        $queue = new XPSPL\Queue();
        $queue->enqueue(1, 10);
        $queue->enqueue(2, 11);
        $queue->enqueue(3, 9);
        $queue->sort();
        $test->equal(3, $queue->current()[0]);
        $queue->next();
        $test->equal(1, $queue->current()[0]);
        $queue->next();
        $test->equal(2, $queue->current()[0]);
    }, "Queue Min Sort");
    
    $suite->test(function($test){
        $queue = new XPSPL\Queue();
        $queue->enqueue(1);
        $queue->enqueue(2);
        $queue->enqueue(3);
        $i = 1;
        foreach($queue->storage() as $_node) {
            $test->equal($_node[0], $i);
            $queue->dequeue($_node[0]);
            $i++;
        }
    }, 'Queue dequeue reset');
});
