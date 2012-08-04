<?php

prggmr\load_signal('object');

/**
 * Handle methods as signal handlers.
 */
class User extends \prggmr\signal\object\Handler {

    public function hello_world()
    {
        echo "HelloWorld";
    }

}

prggmr\handle(new User());
prggmr\signal('hello_world');