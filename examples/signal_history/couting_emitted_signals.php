<?php
ini_set('memory_limit', '10G');
xp_set_signal_history(true);
$sig = XP_SIG('foo');
$time = time();
// Emit a few foo objects
for($i=0;$i<10000000;$i++){
    xp_emit($sig);
}
$end = time();
$emitted = 0;
foreach(xp_signal_history() as $_node) {
    if ($_node[0]->compare($sig)) {
        $emitted++;
    }
}
echo 'Emitted '.$emitted.' signals in ' . ( $end - $time ) . ' seconds' . PHP_EOL;
echo 'Rate of '. ($emitted / ($end-$time));