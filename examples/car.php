<?php

prggmr\handle('light.green', function(){
    echo "The ".$this->car." car is moving";
    $this->car_speed = 100;
});

prggmr\signal_interrupt('light.green', function(){
    $this->car = 'Honda S2000';
});

prggmr\signal_interrupt('light.green', function(){
    echo "The ".$this->car." is going ".$this->car_speed."MPH!!";
}, \prggmr\Engine::INTERRUPT_POST);

prggmr\signal('light.green');