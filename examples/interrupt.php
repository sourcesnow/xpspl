<?php

// Handle Foo
signal(XP_SIG('foo'), function($signal){
    echo $signal->bar;
});

// When foo is emitted insert bar into the event
before(XP_SIG('foo'), function($signal){
    echo "I RAN".PHP_EOL;
    $signal->bar = 'foo';
});

before(XP_SIG('foo'), high_priority(function($signal){
    echo "I RAN BEFORE".PHP_EOL;
}));

// After foo is emitted unset bar in the event
after(XP_SIG('foo'), function($signal){
    unset($signal->bar);
});

$signal = emit(XP_SIG('foo'));
var_dump(isset($signal->bar));