<?php

/**
 * Handle methods as signal handlers.
 */
class User extends \prggmr\Listener {

    public function on_hello_world($event)
    {
        echo "HelloWorld".PHP_EOL;
    }

    public function on_load($event)
    {
        echo $event->injected;
        echo "asdfsadf".PHP_EOL;
    }
}

prggmr\listen(new User());

prggmr\handle('hello_world', function(){
    echo "HelloWorld2".PHP_EOL;
});

// Inject into the event before the on_load method is called!
prggmr\signal_interrupt("load", function(){
    $this->db = "MY DB";
    $this->injected = "Some real shit";
});

prggmr\signal('hello_world');

prggmr\signal('load');