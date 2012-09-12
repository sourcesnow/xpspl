<?php
date_default_timezone_set('UTC');

prggmr\load_module('cron');
// Run every minute
prggmr\module\cron\cron('* * * * *', function(){
    echo "EVERY MINUTE!".PHP_EOL;
});