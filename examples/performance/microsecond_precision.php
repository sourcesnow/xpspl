<?php
print microseconds();
xp_import('time');
$precision = 500;
$signal = new \time\SIG_Awake($precision, TIME_MICROSECONDS);
$precision_timing = [];
signal($signal, exhaust(5500, function($signal) use ($precision, &$precision_timing){
    if (!isset($signal->time)) {
        $signal->time = microseconds();
        return true;
    }
    $timing = (floatval((microseconds() - $signal->time) * 1000000) - $precision);
    if ($timing > 1000 || $timing < 0) {
        // Second change
        $signal->time = microseconds();
        return;
    }
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