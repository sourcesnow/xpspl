<?php
ini_set('memory_limit', -1);

if (function_exists('xdebug_start_code_coverage')) {
    exit('xdebug code coverage detected disable to run performance tests');
}

import('unittest');

$output = unittest\Output::instance();

$tests = [
    'Signal Installation' =>
    function($i){
        signal($i, function(){}); 
    },
    'Signal Emit' => 
    function($i){
        emit($i);
    },
];

$output::send('Beginning performance tests');
$results = [];
foreach ($tests as $_test => $_func) {
    $results[$_test] = [];
    for ($i=1;$i<6;$i++) {
        $output::send(sprintf(
            'Running %s test %s of %s',
            $_test,
            $i, 5
        ));
        for($a=1;$a<(1 << 16);) {
            $a = $a << 1;
            $output::send('Test Size : ' . $a);
            $tc = $a;
            $start = microtime(true);
            if (!isset($results[$_test][$tc])) {
                $results[$_test][$tc] = [];
            }
            for ($c=0;$c<$tc;$c++) {
                $_func($c);
            }
            $end = microtime(true);
            $results[$_test][$tc][] = $end - $start;
            xpspl_flush();
        }
    }
    $output::send(sprintf(
        'Test %s complete',
        $_test
    ));
}
$avg = function($array) {
    $total = 0.00;
    foreach ($array as $_c) { $total += $_c; }
    return round(count($array) / $total, 8);
};
$output->send_linebreak();
foreach ($results as $_test => $_results) {
    $output::send(sprintf(
        'Test %s results',
        $_test
    ));
    $output->send_linebreak();
    foreach ($_results as $_size => $_total) {
        $output::send(sprintf(
            'Size : %s',
            $_size
        ));
        $output::send(sprintf(
            'Time : %s',
            $avg($_total)
        ));
    }
}
// $time = microtime(true);
// echo "Start".PHP_EOL;;
// for ($i=0;$i!=1000;$i++){
//     prggmr\handle($i, function(){
//     });
// }
// echo "Handle Register".PHP_EOL;
// echo microtime(true) - $time;
// echo PHP_EOL;
// $event = new \prggmr\Event();
// $event->a = 1;
// $time = microtime(true);
// for ($i=0;$i!=1000;$i++){
//     prggmr\signal($i, $event);
// }
// echo $event->a.PHP_EOL;
// echo "Signal Calls".PHP_EOL;
// echo microtime(true) - $time;
