<?php
error_reporting(E_ALL);

prggmr\load_signal("time");
prggmr\handle(function(){
    echo "Loop Starting Here";
}, new \prggmr\engine\signal\Loop_Start());
prggmr\handle(function(){
    echo "Loop Ending";
}, new \prggmr\engine\signal\Loop_Shutdown());

prggmr\handle(function(){
    // throw new Exception("HAHA");
}, new \prggmr\engine\signal\Loop_Shutdown());

// prggmr\signal\time\interval(function(){
//     echo "1 second".PHP_EOL;;
// }, 1, \prggmr\engine\idle\Time::SECONDS);

prggmr\signal\time\interval(function(){
    echo "1 milliseconds".PHP_EOL;
}, 1, \prggmr\engine\idle\Time::MILLISECONDS);

prggmr\signal\time\interval(function(){
    echo "1 microsecond".PHP_EOL;
}, 1, \prggmr\engine\idle\Time::MICROSECONDS);