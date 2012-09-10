<?php
error_reporting(E_ALL);

prggmr\load_module("time");

prggmr\handle(new \prggmr\engine\signal\Loop_Start(), function(){
    echo "Loop Starting Here".PHP_EOL;
});
prggmr\handle(new \prggmr\engine\signal\Loop_Shutdown(), function(){
    echo "Loop Ending".PHP_EOL;
});

prggmr\module\time\interval(10, function(){
    echo "10 seconds".PHP_EOL;
}, prggmr\engine\idle\Time::SECONDS);

prggmr\module\time\interval(1, function(){
    echo "1 millisecond".PHP_EOL;
});
