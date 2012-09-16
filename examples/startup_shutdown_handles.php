<?php

prggmr\handle(new prggmr\engine\signal\Loop_Shutdown(), function(){
    echo "The engine is shutting down!";
});

prggmr\handle(new prggmr\engine\signal\Loop_Start(), function(){
    echo "The loop is starting";
});
