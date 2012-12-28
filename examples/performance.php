<?php
ini_set('memory_limit', -1);

if (function_exists('xdebug_start_code_coverage')) {
    exit('xdebug code coverage detected disable to run performance tests');
}

$output = prggmr\unittest\Output::instance();

$tests = [
    'Handle Registration' =>
    function($i){
        prggmr\handle($i, function(){}); 
    },
    'Signal Trigger' => 
    function($i){
        prggmr\signal($i);
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
        for($a=0;$a<10;$a++) {
            $tc = pow($a, 5);
            $start = microtime(true);
            if (!isset($results[$_test][$tc])) {
                $results[$_test][$tc] = [];
            }
            for ($c=0;$c<$tc;$c++) {
                $_func($c);
            }
            $end = microtime(true);
            $results[$_test][$tc][] = $end - $start;
            prggmr\flush();
        }
    }
    $output::send(sprintf(
        'Test %s complete',
        $_test
    ));
}
var_dump($results);
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
