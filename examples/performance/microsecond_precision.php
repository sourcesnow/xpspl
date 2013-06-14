<?php
$start = microtime(true);
usleep(10);
$end = microtime(true);
echo $start.PHP_EOL;
echo $end.PHP_EOL;
echo $end - $start.PHP_EOL;
exit;
import('time');
$precision = 500;
$signal = new \time\SIG_Awake($precision, TIME_MICROSECONDS);
$precision_timing = [];
signal($signal, exhaust(500, function($signal) use ($precision, &$precision_timing){
    if (!isset($signal->time)) {
        $signal->time = microtime(true);
        return true;
    }
    $timing = (floatval((microseconds() - $signal->time) * 1000000) - $precision);
    // if ($timing > 100000 || $timing < 0) {
    //     // Second change
    //     $timing = 0;
    // }
    $precision_timing[] = [$timing, 0];
    $signal->time = microseconds();
}));
on_shutdown(function() use (&$precision_timing){
    array_shift($precision_timing);
    $results = ['usPrecision' => $precision_timing];
    ob_start();
    include dirname(realpath(__FILE__)).'/chart.php';
    $data = ob_get_contents();
    ob_end_clean();
    file_put_contents('microsecond_precision.html', $data);
    echo "Performance chart in precision.html".PHP_EOL;
});