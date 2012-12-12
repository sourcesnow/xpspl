<?php
ini_set('memory_limit', -1);
$time = microtime(true);
echo "Start".PHP_EOL;;
for ($i=0;$i!=5000;$i++){
    prggmr\handle($i, function(){
    });
}
echo "Handle Register".PHP_EOL;
echo microtime(true) - $time;
echo PHP_EOL;
$event = new \prggmr\Event();
$event->a = 1;
$time = microtime(true);
for ($i=0;$i!=5000;$i++){
    prggmr\signal($i, $event);
}
echo $event->a.PHP_EOL;
echo "Signal Calls".PHP_EOL;
echo microtime(true) - $time;
