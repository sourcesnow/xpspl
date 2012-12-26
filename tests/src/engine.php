<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

load_module('unittest');

unittest\suite(function(){

    $this->setup(function(){
        $this->engine = new xpspl\Engine(true, true);
    });

    $this->teardown(function(){
        unset($this->engine);
    });
    $this->test(function(){
        $this->equal($this->engine->get_state(), STATE_DECLARED);
    }, 'Engine Construction');
    
    $this->test(function(){
        $engine = new \xpspl\Engine(false);
        $this->false($engine->signal_history());
        $engine->emit('test');
        $this->false($engine->signal_history());
    }, 'construct_no_history');

    $this->test(function(){
        $this->engine->emit('test');
        $this->count($this->engine->signal_history(), 1);
        $this->engine->erase_history();
        $this->count($this->engine->signal_history(), 0);
    }, 'erase_history');

    $this->test(function(){
        $this->engine->signal('test', function(){});
        $this->false($this->engine->has_signal_exhausted('test'));
        $this->engine->emit('test');
        $queue = $this->engine->search_signals('test');
        $this->instanceof($queue, new \xpspl\Queue());
        $this->count($queue->storage(), 0);
    }, 'auto_remove_exhausted');

    $this->test(function(){
        // String based
        $this->engine->register_signal('test');
        $queue = $this->engine->search_signals('test');
        $this->instanceof(
            $this->engine->search_signals('test'), 
            new \xpspl\Queue()
        );
        $this->engine->delete_signal('test');
        $this->null($this->engine->search_signals('test'));
        // Class Based
        $signal = new \xpspl\Signal('test');
        $this->engine->register_signal($signal);
        $this->instanceof(
            $this->engine->search_signals($signal), 
            new \xpspl\Queue()
        );
        $this->engine->delete_signal($signal);
        $this->null($this->engine->search_signals($signal));
        // Delete history
        $this->engine->signal($signal, function(){});
        $this->engine->emit($signal);
        $history = $this->engine->signal_history();
        // Need to implement a search history function ... ?
        $count = 0;
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $this->equal($count, 1);
        // Delete signal keep history
        $this->engine->register_signal($signal);
        $this->engine->delete_signal($signal, false);
        $history = $this->engine->signal_history();
        $count = 0;
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $this->equal($count, 1);
        // Delete signal remove history
        $this->engine->register_signal($signal);
        $this->engine->delete_signal($signal, true);
        $count = 0;
        $history = $this->engine->signal_history();
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $this->equal($count, 0);
    }, 'delete_signal');
    
    // $this->test(function(){
    //     $this->engine->enable_signaled_exceptions();
    //     $this->engine_error_signaled('Invalid_Handle', function(){
    //         $this->engine->signal('test', null);
    //     });
    //     $this->engine->disable_signaled_exceptions();
    //     $this->engine_error_not_signaled('Invalid_Handle', function(){
    //         $this->engine->signal('test', null);
    //     });
    // }, 'enable_signaled_exceptions,disable_signaled_exceptions');

    $this->test(function(){
        $this->engine->signal('test', function(){});
        $this->false($this->engine->has_signal_exhausted('test'));
        $this->engine->emit('test');
        $this->true($this->engine->has_signal_exhausted('test'));
    }, "has_signal_exhausted");

    $this->test(function(){
        $this->engine->signal('test', function(){});
        $queue = $this->engine->search_signals('test');
        $this->false($this->engine->queue_exhausted($queue));
        $this->engine->emit('test');
        $this->true($this->engine->queue_exhausted($queue));
        $this->count($queue->storage(), 0);
    }, 'queue_exhausted');

    $this->test(function(){
        $this->engine->signal('test', new xpspl\Handle(function(){}, null));
        $this->engine->emit('test');
        $this->equal($this->engine->get_state(), STATE_DECLARED);
        $this->count($this->engine->signal_history(), 1);
        $this->instanceof(
            $this->engine->search_signals('test'), 
            new xpspl\Queue()
        );
        $this->false($this->engine->has_signal_exhausted('test'));
        $this->engine->flush();
        $this->equal($this->engine->get_state(), STATE_DECLARED);
        $this->null($this->engine->search_signals('test'));
        $this->count($this->engine->signal_history(), 0);
    }, 'flush');

    $this->test(function(){
        $handle = $this->engine->signal('test', function(){});
        $this->instanceof($handle, 'xpspl\Handle');
        $queue = $this->engine->search_signals('test');
        $this->count($queue->storage(), 1);
        $this->false($this->engine->has_signal_exhausted('test'));
        $this->engine->remove_handle('test', $handle);
        $this->count($queue->storage(), 0);
        $this->true($this->engine->has_signal_exhausted('test'));
    }, 'handle,handle_remove');

    $this->test(function(){
        class TL extends xpspl\Listener {
            public function test($event) {
                $event->test = true;
            }
        }
        $this->engine->listen(new TL());
        $queue = $this->engine->search_signals('test');
        $this->notnull($queue);
        $this->instanceof($queue, 'xpspl\Queue');
        // var_dump($this->engine);
        $this->count($queue->storage(), 1);
        $this->false($this->engine->has_signal_exhausted('test'));
        $event = $this->engine->emit('test');
        $this->true($event->test);
    }, 'listen');

    // $this->test(function(){
    //     $this->engine_error_signaled('Invalid_Signal', function(){
    //         $this->engine->register_signal(false);
    //     });
    //     $this->engine_error_not_signaled('Invalid_Signal', function(){
    //         $this->engine->register_signal(1);
    //     });
    //     $queue = $this->engine->register_signal('test');
    //     $this->notnull($queue);
    //     $this->instanceof($queue, 'xpspl\Queue');
    // }, 'register');

    $this->test(function(){
        $this->engine->register_signal('test');
        $this->notnull($this->engine->search_signals('test'));
        $this->instanceof(
            $this->engine->search_signals('test'),
            'xpspl\Queue'
        );
        class CMP extends xpspl\signal\Complex {}
        $cmp = new CMP();
        $this->engine->register_signal($cmp);
        $this->notnull($this->engine->search_signals($cmp));
        $this->instanceof(
            $this->engine->search_signals($cmp),
            'xpspl\Queue'
        );
        $index = $this->engine->search_signals($cmp, true);
        $this->string($index);
    }, 'search_signals');

    $this->test(function(){
        class EVL extends xpspl\signal\Complex {
            public function evaluate($signal = null) {
                return true;
            }
        }
        class EVF extends xpspl\signal\Complex {
            public function evaluate($signal = null) {
                return false;
            }
        }
        $evl = new EVL();
        $evf = new EVF();
        $this->null($this->engine->evaluate_signals('test'));
        $this->engine->register_signal($evl);
        $this->engine->register_signal($evf);
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
        $this->engine->signal('test', function() use ($test){
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
        $event = $this->engine->emit('test');
        $this->isset('count', $event);
        $this->equal($event->count, 3);
        // Complex
        class CBA extends \xpspl\signal\Complex {
            public function evalute($signal = null) {
            }
        }
        $this->engine->before(new CBA(), function(){
        });
        $this->engine->emit('test');
    }, 'before,after');

    $this->test(function(){
        $this->engine->register_signal('test');
        $this->notnull($this->engine->search_signals('test'));
        $this->instanceof(
            $this->engine->search_signals('test'), 
            new \xpspl\Queue()
        );
        $this->engine->clean();
        $this->null($this->engine->search_signals('test'));
        $this->engine->register_signal('test');
        $this->engine->signal('test', function(){});
        $this->notnull($this->engine->search_signals('test'));
        $this->false($this->engine->queue_exhausted(
            $this->engine->search_signals('test')
        ));
        $this->engine->emit('test');
        $this->engine->clean(true);
        $this->null($this->engine->search_signals('test'));
        $this->count($this->engine->signal_history(), 0);
    }, 'clean');
});