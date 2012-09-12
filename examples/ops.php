<?php

/**
 *  Test the number of operations performed per second.
 */
class OPS extends prggmr\signal\Complex 
{
    public function routine($h = null) 
    {
        $this->signal_this();
        return true;
    }
}

$a = 0;
// Handle an unlimited amount of Ops
prggmr\handle('op', new prggmr\Handle(function() use (&$a) {
    $a++;
}, null));

prggmr\load_module('time');

// Run the test for 1 Second
prggmr\module\time\timeout(10000, function(){
    prggmr\shutdown();
});

prggmr\module\time\interval(0, function(){
    prggmr\signal('op');
});

prggmr\handle(new prggmr\engine\signal\Loop_Shutdown(), function() use (&$a){
    echo "Ran $a Complex signal calcuations".PHP_EOL;
});
