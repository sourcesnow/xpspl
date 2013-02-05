<?php
date_default_timezone_set('America/New_York');
$database = new \XPSPL\database\Processes();
$process_1 = new \XPSPL\Process(function(){});
$process_2 = high_priority(function(){});
for ($i=0;$i<10;$i++) {
    $database->install($process_1);
}
