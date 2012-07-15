<?php

prggmr\load_signal("time");

prggmr\handle(function(){
    echo "Loop Starting Here";
}, new \prggmr\engine\signal\Loop_Start());

prggmr\handle(function(){
    echo "Loop END";
}, new \prggmr\engine\signal\Loop_Shutdown());

prggmr\signal\time\interval(function(){
    echo "1 1/2 Second".PHP_EOL;
}, 1500);

prggmr\signal\time\timeout(function(){
    prggmr\shutdown();
    echo "5 Seconds".PHP_EOL;
}, 5000);