<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

prggmr\load_module('unittest');

prggmr\suite(function(){

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
        $this->false($engine->event_history());
        $engine->signal('test');
        $this->false($engine->event_history());
    }, 'construct_no_history');

    $this->test(function(){
        $this->engine->signal('test');
        $this->count($this->engine->event_history(), 1);
        $this->engine->erase_history();
        $this->count($this->engine->event_history(), 0);
    }, 'erase_history');

    $this->test(function(){
        $this->engine->handle('test', function(){});
        $this->false($this->engine->has_signal_exhausted('test'));
        $this->engine->signal('test');
        $queue = $this->engine->search_signals('test');
        $this->instanceof($queue, new \prggmr\Queue());
        $this->count($queue->storage(), 0);
    }, 'auto_remove_exhausted');

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
    }, 'delete_signal');
    
    $this->test(function(){
        $this->engine->enable_signaled_exceptions();
        $this->engine_error_signaled('Invalid_Handle', function(){
            $this->engine->handle('test', null);
        });
        $this->engine->disable_signaled_exceptions();
        $this->engine_error_not_signaled('Invalid_Handle', function(){
            $this->engine->handle('test', null);
        });
    }, 'enable_signaled_exceptions,disable_signaled_exceptions');

    $this->test(function(){
        $this->engine->handle('test', function(){});
        $this->false($this->engine->has_signal_exhausted('test'));
        $this->engine->signal('test');
        $this->true($this->engine->has_signal_exhausted('test'));
    }, "has_signal_exhausted");

    $this->test(function(){
        $this->engine->handle('test', function(){});
        $queue = $this->engine->search_signals('test');
        $this->false($this->engine->queue_exhausted($queue));
        $this->engine->signal('test');
        $this->true($this->engine->queue_exhausted($queue));
        $this->count($queue->storage(), 0);
    }, 'queue_exhausted');

    $this->test(function(){
        $this->engine->handle('test', new prggmr\Handle(function(){}, null));
        $this->engine->signal('test');
        $this->equal($this->engine->get_state(), STATE_DECLARED);
        $this->count($this->engine->event_history(), 1);
        $this->instanceof(
            $this->engine->search_signals('test'), 
            new prggmr\Queue()
        );
        $this->false($this->engine->has_signal_exhausted('test'));
        $this->engine->flush();
        $this->equal($this->engine->get_state(), STATE_DECLARED);
        $this->null($this->engine->search_signals('test'));
        $this->count($this->engine->event_history(), 0);
    }, 'flush');

    $this->test(function(){
        $handle = $this->engine->handle('test', function(){});
        $this->instanceof($handle, 'prggmr\Handle');
        $queue = $this->engine->search_signals('test');
        $this->count($queue->storage(), 1);
        $this->false($this->engine->has_signal_exhausted('test'));
        $this->engine->handle_remove('test', $handle);
        $this->count($queue->storage(), 0);
        $this->true($this->engine->has_signal_exhausted('test'));
    }, 'handle,handle_remove');

    $this->test(function(){
        class TL extends prggmr\Listener {
            public function test($event) {
                $event->test = true;
            }
        }
        $this->engine->listen(new TL());
        $queue = $this->engine->search_signals('test');
        $this->notnull($queue);
        $this->instanceof($queue, 'prggmr\Queue');
        // var_dump($this->engine);
        $this->count($queue->storage(), 1);
        $this->false($this->engine->has_signal_exhausted('test'));
        $event = $this->engine->signal('test');
        $this->true($event->test);
    }, 'listen');

    $this->test(function(){
        $this->engine_error_signaled('Invalid_Signal', function(){
            $this->engine->register(false);
        });
        $this->engine_error_not_signaled('Invalid_Signal', function(){
            $this->engine->register(1);
        });
        $queue = $this->engine->register('test');
        $this->notnull($queue);
        $this->instanceof($queue, 'prggmr\Queue');
    }, 'register');

    $this->test(function(){
        $this->engine->register('test');
        $this->notnull($this->engine->search_signals('test'));
        $this->instanceof(
            $this->engine->search_signals('test'),
            'prggmr\Queue'
        );
        class CMP extends prggmr\signal\Complex {}
        $cmp = new CMP();
        $this->engine->register($cmp);
        $this->notnull($this->engine->search_signals($cmp));
        $this->instanceof(
            $this->engine->search_signals($cmp),
            'prggmr\Queue'
        );
        $index = $this->engine->search_signals($cmp, true);
        $this->string($index);
    }, 'search_signals');

    $this->test(function(){
        class EVL extends prggmr\signal\Complex {
            public function evaluate($signal = null) {
                return true;
            }
        }
        class EVF extends prggmr\signal\Complex {
            public function evaluate($signal = null) {
                return false;
            }
        }
        $evl = new EVL();
        $evf = new EVF();
        $this->null($this->engine->evaluate_signals('test'));
        $this->engine->register($evl);
        $this->engine->register($evf);
        $eval = $this->engine->evaluate_signals('test');
        $this->array($eval);
        $this->count($eval, 1);
        $this->true($eval[0][1]);
        $this->engine->delete_signal($evl);
        $this->null($this->engine->evaluate_signals('test'));
    }, 'evaluate_signals');

    $this->test(function(){
        // Simple
        $test = $this;
        $this->engine->handle('test', function() use ($test){
            $test->isset('count', $this);
            $test->equal($this->count, 1);
            $this->count++;
        });
        $this->engine->before('test', function() use ($test){
            $this->count = 1;
        });
        $this->engine->after('test', function() use ($test){
            $test->equal($this->count, 2);
        });
        $this->engine->after('test', function(){
            $this->count++;
        });
        $event = $this->engine->signal('test');
        $this->isset('count', $event);
        $this->equal($event->count, 3);
        // Complex
        class CBA extends \prggmr\signal\Complex {
            public function evalute($signal = null) {
            }
        }
        $this->engine->before(new CBA(), function(){
        });
        $this->engine->signal('test');
    }, 'before,after');

    $this->test(function(){
        $this->engine->register('test');
        $this->notnull($this->engine->search_signals('test'));
        $this->instanceof(
            $this->engine->search_signals('test'), 
            new \prggmr\Queue()
        );
        $this->engine->clean();
        $this->null($this->engine->search_signals('test'));
        $this->engine->register('test');
        $this->engine->handle('test', function(){});
        $this->notnull($this->engine->search_signals('test'));
        $this->false($this->engine->queue_exhausted(
            $this->engine->search_signals('test')
        ));
        $this->engine->signal('test');
        $this->engine->clean(true);
        $this->null($this->engine->search_signals('test'));
        $this->count($this->engine->event_history(), 0);
    }, 'clean');
});