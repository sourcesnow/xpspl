<?php
date_default_timezone_set('UTC');
prggmr\load_signal('time');


// Run every minute
prggmr\signal\time\cron(function(){
    echo "EVERY MINUTE!".PHP_EOL;
}, '* * * * *');