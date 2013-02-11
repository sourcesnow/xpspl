<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

unittest\suite(function($suite){

    $suite->setup(function($test){
        $test->processor = new XPSPL\Processor(true, true);
    });

    $suite->teardown(function($test){
        unset($test->processor);
    });

    // $suite->test(function($test){
    //     $test->equal($test->processor->get_state(), STATE_DECLARED);
    // }, 'Processor Construction');
    
    // $suite->test(function($test){
    //     $processor = new \XPSPL\Processor(false);
    //     $test->false($processor->signal_history());
    //     $processor->emit('test');
    //     $test->false($processor->signal_history());
    // }, 'construct_no_history');

    // $suite->test(function($test){
    //     $test->processor->emit(new \XPSPL\SIG('test'));
    //     $test->count($test->processor->signal_history(), 1);
    //     $test->processor->erase_history();
    //     $test->count($test->processor->signal_history(), 0);
    // }, 'erase_history');

    // $suite->test(function($test){
    //     $test->processor->signal('test', function(){});
    //     $test->false($test->processor->has_signal_exhausted('test'));
    //     $test->processor->emit('test');
    //     $queue = $test->processor->search_signals('test');
    //     $test->instanceof($queue, new \XPSPL\Queue());
    //     $test->count($queue->get_storage(), 0);
    // }, 'auto_remove_exhausted');

    // // $suite->test(function($test){
    // //     // String based
    // //     $test->processor->register_signal(new \XPSPL\SIG('test'));
    // //     $test->instanceof(
    // //         $test->processor->find_signal_database(new \XPSPL\SIG('test')), 
    // //         'XPSPL\database\Signals'
    // //     );
    // //     $test->processor->delete_signal('test');
    // //     $test->null($test->processor->find_signal_database(SIG('test')));
    // //     $signal = new \XPSPL\SIG('test');
    // //     // Delete history
    // //     $test->processor->signal(SIG($signal), new \XPSPL\Process(function(){}));
    // //     $test->processor->emit(SIG($signal));
    // //     $history = $test->processor->signal_history();
    // //     // Need to implement a search history function ... ?
    // //     $count = 0;
    // //     foreach ($history as $_record) {
    // //         if ($_record[1] === $signal) {
    // //             $count++;
    // //         }
    // //     }
    // //     $test->equal($count, 1);
    // //     // Delete signal keep history
    // //     $test->processor->register_signal($signal);
    // //     $test->processor->delete_signal($signal, false);
    // //     $history = $test->processor->signal_history();
    // //     $count = 0;
    // //     foreach ($history as $_record) {
    // //         if ($_record[1] === $signal) {
    // //             $count++;
    // //         }
    // //     }
    // //     $test->equal($count, 1);
    // //     // Delete signal remove history
    // //     $test->processor->register_signal($signal);
    // //     $test->processor->delete_signal($signal, true);
    // //     $count = 0;
    // //     $history = $test->processor->signal_history();
    // //     foreach ($history as $_record) {
    // //         if ($_record[1] === $signal) {
    // //             $count++;
    // //         }
    // //     }
    // //     $test->equal($count, 0);
    // // }, 'delete_signal');
    
    // // $suite->test(function($test){
    // //     $test->processor->enable_signaled_exceptions();
    // //     $test->processor_error_signaled('Invalid_Process', function(){
    // //         $test->processor->signal('test', null);
    // //     });
    // //     $test->processor->disable_signaled_exceptions();
    // //     $test->processor_error_not_signaled('Invalid_Process', function(){
    // //         $test->processor->signal('test', null);
    // //     });
    // // }, 'enable_signaled_exceptions,disable_signaled_exceptions');

    // $suite->test(function($test){
    //     $test->processor->signal('test', function(){});
    //     $test->false($test->processor->has_signal_exhausted('test'));
    //     $test->processor->emit('test');
    //     $test->true($test->processor->has_signal_exhausted('test'));
    // }, "has_signal_exhausted");

    // $suite->test(function($test){
    //     $test->processor->signal('test', function(){});
    //     $queue = $test->processor->search_signals('test');
    //     $test->false($test->processor->queue_exhausted($queue));
    //     $test->processor->emit('test');
    //     $test->true($test->processor->queue_exhausted($queue));
    //     $test->count($queue->get_storage(), 0);
    // }, 'queue_exhausted');

    // $suite->test(function($test){
    //     $test->processor->signal('test', new XPSPL\Process(function(){}, null));
    //     $test->processor->emit('test');
    //     $test->equal($test->processor->get_state(), STATE_DECLARED);
    //     $test->count($test->processor->signal_history(), 1);
    //     $test->instanceof(
    //         $test->processor->search_signals('test'), 
    //         new XPSPL\Queue()
    //     );
    //     $test->false($test->processor->has_signal_exhausted('test'));
    //     $test->processor->flush();
    //     $test->equal($test->processor->get_state(), STATE_DECLARED);
    //     $test->null($test->processor->search_signals('test'));
    //     $test->count($test->processor->signal_history(), 0);
    // }, 'flush');

    // $suite->test(function($test){
    //     $process = $test->processor->signal('test', function(){});
    //     $test->instanceof($process, 'XPSPL\Process');
    //     $queue = $test->processor->search_signals('test');
    //     $test->count($queue->get_storage(), 1);
    //     $test->false($test->processor->has_signal_exhausted('test'));
    //     $test->processor->delete_process('test', $process);
    //     $test->count($queue->get_storage(), 0);
    //     $test->true($test->processor->has_signal_exhausted('test'));
    // }, 'process,process_remove');

    // $suite->test(function($test){
    //     class TL extends XPSPL\Listener {
    //         public function test($event) {
    //             $event->test = true;
    //         }
    //     }
    //     $test->processor->listen(new TL());
    //     $queue = $test->processor->search_signals('test');
    //     if (!$test->notnull($queue)) {
    //         $test->mark_skipped(4);
    //         return;
    //     }
    //     if (!$test->instanceof($queue, 'XPSPL\Queue')) {
    //         $test->mark_skipped(3);
    //         return;
    //     }
    //     if (!$test->count($queue->get_storage(), 1)) {
    //         $test->mark_skipped(2);
    //         return;
    //     }
    //     $test->false($test->processor->has_signal_exhausted('test'));
    //     $event = $test->processor->emit('test');
    //     $test->true($event->test);
    // }, 'listen');

    // // $suite->test(function($test){
    // //     $test->processor_error_signaled('Invalid_Signal', function(){
    // //         $test->processor->register_signal(false);
    // //     });
    // //     $test->processor_error_not_signaled('Invalid_Signal', function(){
    // //         $test->processor->register_signal(1);
    // //     });
    // //     $queue = $test->processor->register_signal('test');
    // //     $test->notnull($queue);
    // //     $test->instanceof($queue, 'XPSPL\Queue');
    // // }, 'register');

    // $suite->test(function($test){
    //     $test->processor->register_signal('test');
    //     $test->notnull($test->processor->search_signals('test'));
    //     $test->instanceof(
    //         $test->processor->search_signals('test'),
    //         'XPSPL\Queue'
    //     );
    //     class CMP extends XPSPL\signal\Complex {}
    //     $cmp = new CMP();
    //     $test->processor->register_signal($cmp);
    //     $test->notnull($test->processor->search_signals($cmp));
    //     $test->instanceof(
    //         $test->processor->search_signals($cmp),
    //         'XPSPL\Queue'
    //     );
    //     $index = $test->processor->search_signals($cmp, true);
    //     $test->string($index);
    // }, 'search_signals');

    // $suite->test(function($test){
    //     class EVL extends XPSPL\signal\Complex {
    //         public function evaluate($signal = null) {
    //             return true;
    //         }
    //     }
    //     class EVF extends XPSPL\signal\Complex {
    //         public function evaluate($signal = null) {
    //             return false;
    //         }
    //     }
    //     $evl = new EVL();
    //     $evf = new EVF();
    //     $test->null($test->processor->evaluate_signals('test'));
    //     $test->processor->register_signal($evl);
    //     $test->processor->register_signal($evf);
    //     $eval = $test->processor->evaluate_signals('test');
    //     $test->array($eval);
    //     $test->count($eval, 1);
    //     $test->true($eval[0][1]);
    //     $test->processor->delete_signal($evl);
    //     $test->null($test->processor->evaluate_signals('test'));
    // }, 'evaluate_signals');

    // $suite->test(function($test){
    //     // Simple
    //     $test = $test;
    //     $test->processor->signal('test', function() use ($test){
    //         $test->isset('count', $test);
    //         $test->equal($test->count, 1);
    //         $test->count++;
    //     });
    //     $test->processor->before('test', function() use ($test){
    //         $test->count = 1;
    //     });
    //     $test->processor->after('test', function() use ($test){
    //         $test->equal($test->count, 2);
    //     });
    //     $test->processor->after('test', function(){
    //         $test->count++;
    //     });
    //     $event = $test->processor->emit('test');
    //     $test->isset('count', $event);
    //     $test->equal($event->count, 3);
    //     // Complex
    //     class CBA extends \XPSPL\signal\Complex {
    //         public function evalute($signal = null) {
    //         }
    //     }
    //     $test->processor->before(new CBA(), function(){
    //     });
    //     $test->processor->emit('test');
    // }, 'before,after');

    // $suite->test(function($test){
    //     $test->processor->register_signal('test');
    //     $test->notnull($test->processor->search_signals('test'));
    //     $test->instanceof(
    //         $test->processor->search_signals('test'), 
    //         new \XPSPL\Queue()
    //     );
    //     $test->processor->clean();
    //     $test->null($test->processor->search_signals('test'));
    //     $test->processor->register_signal('test');
    //     $test->processor->signal('test', function(){});
    //     $test->notnull($test->processor->search_signals('test'));
    //     $test->false($test->processor->queue_exhausted(
    //         $test->processor->search_signals('test')
    //     ));
    //     $test->processor->emit('test');
    //     $test->processor->clean(true);
    //     $test->null($test->processor->search_signals('test'));
    //     $test->count($test->processor->signal_history(), 0);
    // }, 'clean');
});