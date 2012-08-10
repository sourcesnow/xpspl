<?php
prggmr\load_signal('arrays');

prggmr\handle(new \prggmr\signal\arrays\Binary([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]), function($value){
    echo "This used a binary array search";
});

prggmr\signal(1);