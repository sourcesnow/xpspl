<?php

xp_import('network');

$ops = 0;

$thread = xp_threaded_process(function() {
	$start_time = 0;
	$this->operations = 0;
	$sig = XP_SIG('a');
	do {
		echo $ops;
		xp_emit($sig);
		$this->operations++;
		$ops = $this->operations / (microtime(true) - $start_time);
	} while(true);
});

$ops_sig = xp_signal(XP_SIG('op'), xp_exhaust(null, $thread));

xp_emit(XP_SIG('op'));

// $server = network\connect('0.0.0.0', ['port'=>8000]);
// $server->on_connect(xp_null_exhaust(function($server) use ($ops){
// 	$server->socket->write($ops);
// 	$server->socket->disconnect();
// }));
// $server = 

// $iterations = 1000000;
// $start = microtime(true);
// for ($i=0;$i<$iterations;$i++) {}
// $end = microtime(true);
// $loop_time = $end - $start;

// $sig = XP_SIG(null);
// $start = microtime(true);
// for ($i=0;$i<$iterations;$i++) {
// 	xp_emit($sig);
// }
// $end = time(true);
// echo number_format($iterations / (($end - $start)) ) . ' Emits Per Second'.PHP_EOL;