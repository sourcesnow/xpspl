<?php
error_reporting(E_ALL);

prggmr\load_signal("time");
prggmr\handle(new \prggmr\engine\signal\Loop_Start(), function(){
    echo "Loop Starting Here";
});
prggmr\handle(new \prggmr\engine\signal\Loop_Shutdown(), function(){
    echo "Loop Ending";
});

// prggmr\handle(function(){
//     // throw new Exception("HAHA");
// }, new \prggmr\engine\signal\Loop_Shutdown());

prggmr\signal\time\interval(1, function(){
    echo "1 second".PHP_EOL;
}, prggmr\engine\idle\Time::SECONDS);

prggmr\signal\time\interval(1, function(){
    echo "1 microsecond".PHP_EOL;
}, prggmr\engine\idle\Time::MICROSECONDS);
