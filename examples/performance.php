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
$average_perform = 10;
foreach ($tests as $_test => $_func) {
    $results[$_test] = [];
    for ($i=1;$i<$average_perform;$i++) {
        $output::send(sprintf(
            'Running %s test %s of %s',
            $_test,
            $i, $average_perform
        ));
        for($a=1;$a<(1 << 12);) {
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
ob_start();
include dirname(realpath(__FILE__)).'/performance/chart.php';
$data = ob_get_contents();
ob_end_clean();
file_put_contents('performance_chart.html', $data);
echo "Performance chart in performance_chart.html".PHP_EOL;
// $avg = function($array) {
//     $total = 0.00;
//     foreach ($array as $_c) { $total += $_c; }
//     return round(count($array) / $total, 8);
// };
// $output->send_linebreak();
// foreach ($results as $_test => $_results) {
//     $output::send(sprintf(
//         'Test %s results',
//         $_test
//     ));
//     $output->send_linebreak();
//     foreach ($_results as $_size => $_total) {
//         $output::send(sprintf(
//             'Size : %s',
//             $_size
//         ));
//         $output::send(sprintf(
//             'Time : %s',
//             $avg($_total)
//         ));
//     }
// }