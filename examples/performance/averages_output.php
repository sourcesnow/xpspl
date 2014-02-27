<?php
function push_to_array($array1, $js_array) {
    $times = [];
    foreach ($array1 as $_num => $_result) {
        $time = 0.0000;
        foreach ($_result as $_time) {
            $time = $time + $_time;
        }
        // $average = round(count($_result) / $time, 5);
        echo sprintf('%s.push([%f, %f]);'.PHP_EOL,
          $js_array, $_num, $time
        );
    }
}
function make_average($name, $data) {
    global $average_perform;
    $average = 0.000000;
    $averages = [];
    $tests_performed = 0;
    echo $name . ' Performance Test '.PHP_EOL;
    echo 'Tests Performed : ' . count($data) . PHP_EOL;
    echo 'Average Time Spent : ' . number_format(array_sum($data) / count($data), 10).PHP_EOL;
    //     $averages[] = array_sum($_array) / count($_array);
    //     $tests_performed += $_count * $average_perform;
    // echo '--------------------------------------'.PHP_EOL;
    // $total_average = array_sum($averages) / count($averages);
    // echo 'Average Time Spent '. $name . ' - ' . number_format($total_average, 10) . ' seconds ' . PHP_EOL;
    // echo 'Tests Performed : ' . number_format($tests_performed).PHP_EOL;
    echo '--------------------------------------'.PHP_EOL;
}
foreach ($results as $_name => $_data) {
    make_average($_name, $_data);
}