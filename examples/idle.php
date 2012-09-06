<?php
error_reporting(E_ALL);
prggmr\load_signal("time");
prggmr\handle(new \prggmr\engine\signal\Loop_Start(), function(){
    echo "Loop Starting Here".PHP_EOL;
});
prggmr\handle(new \prggmr\engine\signal\Loop_Shutdown(), function(){
    echo "Loop Ending".PHP_EOL;
});

prggmr\signal\time\interval(1, function(){
    echo "1 second".PHP_EOL;
}, prggmr\engine\idle\Time::SECONDS);

// prggmr\signal\time\interval(10, function(){
//     echo "SHUTTING DOWN THE ENGINE".PHP_EOL;
//     prggmr\shutdown();
// }, prggmr\engine\idle\Time::SECONDS);

// prggmr\signal\time\interval(1, function(){
//     echo "1 millisecond".PHP_EOL;
// }, prggmr\engine\idle\Time::MILLISECONDS);

prggmr\signal\time\interval(0.0001, function(){
    echo "1 microsecond".PHP_EOL;
}, prggmr\engine\idle\Time::MICROSECONDS);
