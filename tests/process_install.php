<?php

$database = new \XPSPL\database\Processes();
$process_1 = high_priority(function(){});
$database->enqueue($process_1);
$database->enqueue($process_1);
$database->enqueue($process_1);
$database->enqueue($process_1);
$database->enqueue($process_1);
$database->enqueue($process_1);
var_dump($database);