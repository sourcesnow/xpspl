<?php
declare(ticks=1);
prggmr\load_signal('pcntl');

prggmr\save_event_history(true);

prggmr\handle(function(){
    prggmr\signal('a');
}, 'b', null, null);

prggmr\handle(function(){
    prggmr\signal('c');
    prggmr\signal('b');
}, 'a', null, null);


prggmr\signal\pcntl\interrupt(function(){
    var_dump(prggmr\event_history());
    exit;
});

prggmr\signal('b');
