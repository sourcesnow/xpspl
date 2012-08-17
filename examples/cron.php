<?php
date_default_timezone_set('UTC');
prggmr\load_signal('time');


// Run every minute
prggmr\signal\time\cron('* * * * *', function(){
    echo "EVERY MINUTE!".PHP_EOL;
});

prggmr\handle('signal', function(){

});

$handle = new prggmr\Handle(function(){

}, 1, 0);

prggmr\handle('signal', $handle);