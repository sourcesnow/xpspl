<?php

prggmr\handle('b', function(){
    prggmr\signal('a');
});

prggmr\handle('a', function(){
    prggmr\signal('c');
});

prggmr\signal('b');
prggmr\signal('c');

// !! LIES !! no b never existed or a or c!
prggmr\clean(true);

var_dump(prggmr\prggmr());