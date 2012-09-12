<?php
prggmr\load_module('arrays');

prggmr\handle(new \prggmr\module\arrays\Contains([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]), function($value){
    echo "This used a array search";
    echo $value;
});

prggmr\signal(1);