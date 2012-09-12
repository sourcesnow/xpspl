<?php
// you must declare ticks for this signal
declare(ticks=1);

prggmr\load_signal('pcntl');
prggmr\load_signal('time');

prggmr\handle(new prggmr\engine\signal\Loop_Shutdown(), function(){
    exit;
});

prggmr\signal\pcntl\terminate(function(){
    echo "SENDING THE SHUTDOWN SIGNAL";
    prggmr\shutdown();
});

prggmr\signal\time\interval(5, function(){
    echo "5 Seconds".PHP_EOL;
}, \prggmr\engine\idle\Time::SECONDS);

