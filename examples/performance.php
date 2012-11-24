<?php
prggmr\save_event_history(true);
var_dump(prggmr\event_history());
ini_set('memory_limit', -1);
$time = microtime(true);
echo "Start".PHP_EOL;;
for ($i=0;$i!=10000;$i++){
    prggmr\handle($i, function(){
    });
}
echo "Handle Register".PHP_EOL;
echo microtime(true) - $time;
echo PHP_EOL;
$event = new \prggmr\Event();
$event->a = 1;
$time = microtime(true);
for ($i=0;$i!=10000;$i++){
    prggmr\signal($i, $event);
}
var_dump(prggmr\event_history());
echo $event->a.PHP_EOL;
echo "Signal Calls".PHP_EOL;
echo microtime(true) - $time;
