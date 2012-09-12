<?php
declare(ticks=1);
prggmr\load_module('pcntl');

prggmr\save_event_history(true);

prggmr\handle('b', function(){
    prggmr\signal('a');
});

prggmr\handle('a', function(){
    prggmr\signal('c');
});


prggmr\handle(new prggmr\engine\signal\Loop_Shutdown(), function(){
    var_dump(prggmr\event_history());
});

prggmr\signal('b');
