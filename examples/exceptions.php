<?php

// HANDLE_EXCEPTION
prggmr\handle('error', function(){
    throw new Exception('test');
});

prggmr\signal('error');