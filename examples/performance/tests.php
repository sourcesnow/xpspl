<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
ini_set('memory_limit', -1);

if (function_exists('xdebug_start_code_coverage')) {
    exit('xdebug code coverage detected disable to run performance tests');
}

xp_import('unittest');

$output = unittest\Output::instance();
function a(){}
$tests = [
    'Installation SIG Process' =>
    function($processor, $i){
        $processor->signal($i, xp_null_exhaust(null));
    },
    'Emitting a signal' =>
    function($processor, $i){
        $processor->emit($i);
    },
    'Registering a signal' =>
    function($processor, $i){
        $processor->register_signal($i);
    },
    // 'Listners Installed' =>
    // function($i) {
    //     listen(new Lst());
    // },
    // 'Interruptions Installed' =>
    // function($i){
    //     before($i, function(){});
    // },
    // 'Event Loop' =>
    // function($i) {
    //     xp_wait_loop();
    // },
    // 'Interruption before emit' =>
    // function($i) {
    //     before($i, function(){});
    //     xp_emit($i);
    // },
    // 'Interruption after emit' =>
    // function($i) {
    //     after($i, function(){});
    //     xp_emit($i);
    // },
    // 'Complex Signal Registration' =>
    // function($i) {
    //     register_signal(new Cmp());
    // },
    // 'Complex Signal Evaluation' =>
    // function($i, $setup){
    //     if ($setup) {
    //         signal(new Cmp(), xp_null_exhaust(function(){}));
    //     }
    //     xp_emit('foo');
    // },
    // 'Complex Signal Registration' =>
    // function($i) {
    //     register_signal(new Cmp());
    // },
    // 'Complex Signal Evaluation' =>
    // function($i, $setup){
    //     if ($setup) {
    //         signal(new Cmp(), xp_null_exhaust(function(){}));
    //     }
    //     xp_emit('foo');
    // },
    // 'Complex Signal Interruption Before Install' =>
    // function($i, $setup){
    //     before(new Cmp(), function(){});
    // },
    // 'Complex Signal Interruption After Install' =>
    // function($i, $setup){
    //     after(new Cmp(), function(){});
    // },
    // 'Complex Signal Interruption Before' =>
    // function($i, $setup){
    //     before(new Cmp(), function(){});
    //     emit(new Cmp());
    // },
    // 'Complex Signal Interruption After' =>
    // function($i, $setup){
    //     after(new Cmp(), function(){});
    //     emit(new Cmp());
    // },
];
$output::send('Beginning performance tests ... please be patient.');
$results = [];
$average_perform = 10;
$total_tests = 0;
foreach ($tests as $_test => $_func) {
    $results[$_test] = [];
    $processor = new \XPSPL\Processor();
    $processor->signal_history(false);
    $sig = XP_SIG('a');
    $processor->signal($sig, xp_null_exhaust(null));
    for ($i=1;$i<$average_perform+1;$i++) {
        $output::send(sprintf(
            'Running %s test %s of %s',
            $_test,
            $i, $average_perform
        ));
        for($a=1;$a<(1 << 10);) {
            $a = $a << 1;
            $tc = $a;
            if ($a === 1) {
                $setup = true;
            } else {
                $setup = false;
            }
            if (!isset($results[$_test][$tc])) {
                $results[$_test][$tc] = [];
            }
            for ($c=0;$c<$tc;$c++) {
                // do the test
                $start = microtime(true);
                $_func($processor, $sig);
                $end = microtime(true);
                // add test time
                $results[$_test][] = $end - $start;
                ++$total_tests;
                $processor->flush();
                $processor->signal($sig, xp_null_exhaust(null));
            }
        }
    }
    $output::send(sprintf(
        'Test %s complete',
        $_test
    ));
}
// echo '--------------------------------------'.PHP_EOL;
// echo "Total tests performed " . number_format($total_tests).PHP_EOL;
// ob_start();
include dirname(realpath(__FILE__)).'/averages_output.php';
// $data = ob_get_contents();
// ob_end_clean();
// file_put_contents('performance_chart.html', $data);
// echo "Performance chart in performance_chart.html".PHP_EOL;
