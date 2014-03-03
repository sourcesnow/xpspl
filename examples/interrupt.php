<?php

// Handle Foo
xp_signal(XP_SIG('foo'), function($signal){
    echo $signal->bar;
});

// When foo is emitted insert bar into the event
xp_before(XP_SIG('foo'), function($signal){
    echo "I RAN".PHP_EOL;
    $signal->bar = 'foo';
});

xp_before(XP_SIG('foo'), xp_high_priority(function($signal){
    echo "I RAN BEFORE".PHP_EOL;
}));

// After foo is emitted unset bar in the event
xp_after(XP_SIG('foo'), function($signal){
    unset($signal->bar);
});

$signal = xp_emit(XP_SIG('foo'));
var_dump(isset($signal->bar));