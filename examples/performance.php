<?php
ini_set('memory_limit', -1);
$time = microtime(true);
echo "Start";
for ($i=0;$i!=5000;$i++){
    prggmr\handle($i, function(){
    });
}
echo "Handle Register".PHP_EOL;
echo microtime(true) - $time;
echo PHP_EOL;
$time = microtime(true);
for ($i=0;$i!=5000;$i++){
    prggmr\signal($i);
}
echo "Signal Calls".PHP_EOL;
echo microtime(true) - $time;
