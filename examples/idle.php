<?php
error_reporting(E_ALL);

echo intval(null);
exit;
prggmr\load_signal("time");
prggmr\handle(function(){
    echo "Loop Starting Here";
}, new \prggmr\engine\signal\Loop_Start());

prggmr\handle(function(){
    throw new Exception("HAHA");
}, new \prggmr\engine\signal\Loop_Shutdown());

prggmr\signal\time\interval(function(){
    // echo $this->doesnotexit;
}, 1500);

prggmr\signal\time\timeout(function(){
    prggmr\shutdown();
    echo "5 Seconds".PHP_EOL;
}, 5000);