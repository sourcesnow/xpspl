<?php

// Handle Foo
signal(SIG('foo'), function($signal){
    echo $signal->bar;
});

// When foo is emitted insert bar into the event
before(SIG('foo'), function($signal){
    echo "I RAN".PHP_EOL;
    $signal->bar = 'foo';
});

before(SIG('foo'), high_priority(function($signal){
    echo "I RAN BEFORE".PHP_EOL;
}));

// After foo is emitted unset bar in the event
after(SIG('foo'), function($signal){
    unset($signal->bar);
});

$signal = emit(SIG('foo'));
var_dump(isset($signal->bar));