<?php

prggmr\load_signal("time");

prggmr\handle(function(){
    echo "Loop Start";
}, \prggmr\engine\Signals::LOOP_START);

prggmr\handle(function(){
    echo "Loop END";
}, \prggmr\engine\Signals::LOOP_SHUTDOWN);

prggmr\signal\time\interval(function(){
    echo "1 1/2 Second".PHP_EOL;
}, 1500);

prggmr\signal\time\timeout(function(){
    prggmr\prggmr_shutdown();
    echo "5 Seconds".PHP_EOL;
}, 5000);