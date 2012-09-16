<?php
prggmr\load_module('unittest');
use prggmr\module\unittest as unittest;

// Enable history
prggmr\save_event_history(true);

// unittest\test(function(){
//     echo "MEMEMEME";
//     $this->true(true);
//     $this->true(true);
//     $this->true(true);
//     $this->true(false);
//     $this->true(true);
//     $this->true(true);
// });

unittest\suite(function(){
    $this->setup(function(){
        $this->a = 1;
    });
    // $this->teardown(function(){
    //     echo "TEARDOWN";
    // });
    $this->test(function(){
        $this->true(true);
        $this->equal($this->a, 1);
    });
    $this->test(function(){
        $this->false(true);
    });
});

prggmr\handle(new prggmr\engine\signal\Loop_Shutdown(), function(){
    $tests = 0;
    foreach (prggmr\event_history() as $_node) {
        if ($_node[0] instanceof prggmr\module\unittest\Event) {
            $tests++;
        }
    }
    echo PHP_EOL;
    echo "Ran $tests tests";
    echo PHP_EOL;
});
