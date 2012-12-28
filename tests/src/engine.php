<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

import('unittest');

unittest\suite(function(){

    $this->setup(function(){
        $this->processor = new xpspl\Processor(true, true);
    });

    $this->teardown(function(){
        unset($this->processor);
    });
    $this->test(function(){
        $this->equal($this->processor->get_state(), STATE_DECLARED);
    }, 'Processor Construction');
    
    $this->test(function(){
        $processor = new \xpspl\Processor(false);
        $this->false($processor->signal_history());
        $processor->emit('test');
        $this->false($processor->signal_history());
    }, 'construct_no_history');

    $this->test(function(){
        $this->processor->emit('test');
        $this->count($this->processor->signal_history(), 1);
        $this->processor->erase_history();
        $this->count($this->processor->signal_history(), 0);
    }, 'erase_history');

    $this->test(function(){
        $this->processor->signal('test', function(){});
        $this->false($this->processor->has_signal_exhausted('test'));
        $this->processor->emit('test');
        $queue = $this->processor->search_signals('test');
        $this->instanceof($queue, new \xpspl\Queue());
        $this->count($queue->storage(), 0);
    }, 'auto_remove_exhausted');

    $this->test(function(){
        // String based
        $this->processor->register_signal('test');
        $queue = $this->processor->search_signals('test');
        $this->instanceof(
            $this->processor->search_signals('test'), 
            new \xpspl\Queue()
        );
        $this->processor->delete_signal('test');
        $this->null($this->processor->search_signals('test'));
        // Class Based
        $signal = new \xpspl\Signal('test');
        $this->processor->register_signal($signal);
        $this->instanceof(
            $this->processor->search_signals($signal), 
            new \xpspl\Queue()
        );
        $this->processor->delete_signal($signal);
        $this->null($this->processor->search_signals($signal));
        // Delete history
        $this->processor->signal($signal, function(){});
        $this->processor->emit($signal);
        $history = $this->processor->signal_history();
        // Need to implement a search history function ... ?
        $count = 0;
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $this->equal($count, 1);
        // Delete signal keep history
        $this->processor->register_signal($signal);
        $this->processor->delete_signal($signal, false);
        $history = $this->processor->signal_history();
        $count = 0;
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $this->equal($count, 1);
        // Delete signal remove history
        $this->processor->register_signal($signal);
        $this->processor->delete_signal($signal, true);
        $count = 0;
        $history = $this->processor->signal_history();
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $this->equal($count, 0);
    }, 'delete_signal');
    
    // $this->test(function(){
    //     $this->processor->enable_signaled_exceptions();
    //     $this->processor_error_signaled('Invalid_Handle', function(){
    //         $this->processor->signal('test', null);
    //     });
    //     $this->processor->disable_signaled_exceptions();
    //     $this->processor_error_not_signaled('Invalid_Handle', function(){
    //         $this->processor->signal('test', null);
    //     });
    // }, 'enable_signaled_exceptions,disable_signaled_exceptions');

    $this->test(function(){
        $this->processor->signal('test', function(){});
        $this->false($this->processor->has_signal_exhausted('test'));
        $this->processor->emit('test');
        $this->true($this->processor->has_signal_exhausted('test'));
    }, "has_signal_exhausted");

    $this->test(function(){
        $this->processor->signal('test', function(){});
        $queue = $this->processor->search_signals('test');
        $this->false($this->processor->queue_exhausted($queue));
        $this->processor->emit('test');
        $this->true($this->processor->queue_exhausted($queue));
        $this->count($queue->storage(), 0);
    }, 'queue_exhausted');

    $this->test(function(){
        $this->processor->signal('test', new xpspl\Handle(function(){}, null));
        $this->processor->emit('test');
        $this->equal($this->processor->get_state(), STATE_DECLARED);
        $this->count($this->processor->signal_history(), 1);
        $this->instanceof(
            $this->processor->search_signals('test'), 
            new xpspl\Queue()
        );
        $this->false($this->processor->has_signal_exhausted('test'));
        $this->processor->flush();
        $this->equal($this->processor->get_state(), STATE_DECLARED);
        $this->null($this->processor->search_signals('test'));
        $this->count($this->processor->signal_history(), 0);
    }, 'flush');

    $this->test(function(){
        $handle = $this->processor->signal('test', function(){});
        $this->instanceof($handle, 'xpspl\Handle');
        $queue = $this->processor->search_signals('test');
        $this->count($queue->storage(), 1);
        $this->false($this->processor->has_signal_exhausted('test'));
        $this->processor->remove_handle('test', $handle);
        $this->count($queue->storage(), 0);
        $this->true($this->processor->has_signal_exhausted('test'));
    }, 'handle,handle_remove');

    $this->test(function(){
        class TL extends xpspl\Listener {
            public function test($event) {
                $event->test = true;
            }
        }
        $this->processor->listen(new TL());
        $queue = $this->processor->search_signals('test');
        $this->notnull($queue);
        $this->instanceof($queue, 'xpspl\Queue');
        // var_dump($this->processor);
        $this->count($queue->storage(), 1);
        $this->false($this->processor->has_signal_exhausted('test'));
        $event = $this->processor->emit('test');
        $this->true($event->test);
    }, 'listen');

    // $this->test(function(){
    //     $this->processor_error_signaled('Invalid_Signal', function(){
    //         $this->processor->register_signal(false);
    //     });
    //     $this->processor_error_not_signaled('Invalid_Signal', function(){
    //         $this->processor->register_signal(1);
    //     });
    //     $queue = $this->processor->register_signal('test');
    //     $this->notnull($queue);
    //     $this->instanceof($queue, 'xpspl\Queue');
    // }, 'register');

    $this->test(function(){
        $this->processor->register_signal('test');
        $this->notnull($this->processor->search_signals('test'));
        $this->instanceof(
            $this->processor->search_signals('test'),
            'xpspl\Queue'
        );
        class CMP extends xpspl\signal\Complex {}
        $cmp = new CMP();
        $this->processor->register_signal($cmp);
        $this->notnull($this->processor->search_signals($cmp));
        $this->instanceof(
            $this->processor->search_signals($cmp),
            'xpspl\Queue'
        );
        $index = $this->processor->search_signals($cmp, true);
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
        $this->null($this->processor->evaluate_signals('test'));
        $this->processor->register_signal($evl);
        $this->processor->register_signal($evf);
        $eval = $this->processor->evaluate_signals('test');
        $this->array($eval);
        $this->count($eval, 1);
        $this->true($eval[0][1]);
        $this->processor->delete_signal($evl);
        $this->null($this->processor->evaluate_signals('test'));
    }, 'evaluate_signals');

    $this->test(function(){
        // Simple
        $test = $this;
        $this->processor->signal('test', function() use ($test){
            $test->isset('count', $this);
            $test->equal($this->count, 1);
            $this->count++;
        });
        $this->processor->before('test', function() use ($test){
            $this->count = 1;
        });
        $this->processor->after('test', function() use ($test){
            $test->equal($this->count, 2);
        });
        $this->processor->after('test', function(){
            $this->count++;
        });
        $event = $this->processor->emit('test');
        $this->isset('count', $event);
        $this->equal($event->count, 3);
        // Complex
        class CBA extends \xpspl\signal\Complex {
            public function evalute($signal = null) {
            }
        }
        $this->processor->before(new CBA(), function(){
        });
        $this->processor->emit('test');
    }, 'before,after');

    $this->test(function(){
        $this->processor->register_signal('test');
        $this->notnull($this->processor->search_signals('test'));
        $this->instanceof(
            $this->processor->search_signals('test'), 
            new \xpspl\Queue()
        );
        $this->processor->clean();
        $this->null($this->processor->search_signals('test'));
        $this->processor->register_signal('test');
        $this->processor->signal('test', function(){});
        $this->notnull($this->processor->search_signals('test'));
        $this->false($this->processor->queue_exhausted(
            $this->processor->search_signals('test')
        ));
        $this->processor->emit('test');
        $this->processor->clean(true);
        $this->null($this->processor->search_signals('test'));
        $this->count($this->processor->signal_history(), 0);
    }, 'clean');
});