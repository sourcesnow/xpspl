<?php

// When foo is emitted insert bar into the event
before(SIG('foo'), function($signal){
    echo "I RAN";
    $signal->bar = 'foo';
});

// Handle Foo
signal(SIG('foo'), function($signal){
    echo $signal->bar;
});

// After foo is emitted unset bar in the event
after(SIG('foo'), function($signal){
    unset($signal->bar);
});

$signal = emit(SIG('foo'));
var_dump($signal);
var_dump(isset($signal->bar));