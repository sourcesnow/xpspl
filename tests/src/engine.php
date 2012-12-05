<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

prggmr\load_module('unittest');

use prggmr\module\unittest as unittest;

unittest\suite(function(){

    $this->setup(function(){
        $this->engine = new prggmr\Engine(true, true);
    });

    $this->teardown(function(){
        unset($this->engine);
    });
    $this->test(function(){
        $this->equal($this->engine->get_state(), STATE_DECLARED);
    }, 'Engine Construction');
    
    $this->test(function(){
        $engine = new \prggmr\Engine(false);
        $engine->signal('test');
        $this->count($engine->event_history(), 0);
    }, 'Construction no history');

    $this->test(function(){
        $this->engine->signal('test');
        $this->count($this->engine->event_history(), 1);
        $this->engine->erase_history();
        $this->count($this->engine->event_history(), 0);
    }, 'Engine history management');

    $this->test(function(){
        $this->engine->handle('test', function(){});
        $this->false($this->engine->has_signal_exhausted('test'));
        $this->engine->signal('test');
        $queue = $this->engine->search_signals('test');
        $this->instanceof($queue, new \prggmr\Queue());
        $this->count($queue->storage(), 0);
    }, 'Automatic exhaustion');

    $this->test(function(){
        // String based
        $this->engine->register('test');
        $queue = $this->engine->search_signals('test');
        $this->instanceof(
            $this->engine->search_signals('test'), 
            new \prggmr\Queue()
        );
        $this->engine->delete_signal('test');
        $this->null($this->engine->search_signals('test'));
        // Class Based
        $signal = new \prggmr\Signal('test');
        $this->engine->register($signal);
        $this->instanceof(
            $this->engine->search_signals($signal), 
            new \prggmr\Queue()
        );
        $this->engine->delete_signal($signal);
        $this->null($this->engine->search_signals($signal));
        // Delete history
        $this->engine->handle($signal, function(){});
        $this->engine->signal($signal);
        $history = $this->engine->event_history();
        // Need to implement a search history function ... ?
        $count = 0;
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $this->equal($count, 1);
        // Delete signal keep history
        $this->engine->register($signal);
        $this->engine->delete_signal($signal, false);
        $history = $this->engine->event_history();
        $count = 0;
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $this->equal($count, 1);
        // Delete signal remove history
        $this->engine->register($signal);
        $this->engine->delete_signal($signal, true);
        $count = 0;
        $history = $this->engine->event_history();
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $this->equal($count, 0);
    }, 'Signal Delete');

});