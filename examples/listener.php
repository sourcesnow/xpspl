<?php

/**
 * Handle methods as signal handlers.
 */
class User extends \prggmr\Listener {

    public function on_hello_world()
    {
        echo "HelloWorld";
    }

}

prggmr\listen(new User());
prggmr\signal('hello_world');