<?php

prggmr\load_signal('http');

/**
 * Handle methods as signal handlers.
 */
class User extends \prggmr\Listener {
    
    public function on_user_register(\prggmr\Event $event)
    {
        $user = new \allpro\models\User();
        $user->username = "Test";
        $user->email = "prggmr@gmail.com";
        $user->save();
    }

    public function on_load($event)
    {
        echo $event->injected;
        echo "asdfsadf".PHP_EOL;
    }
}

prggmr\signal_interrurpt(new \flames\signals\Insert(new \allpro\models\User()), function(){
    echo $sql;
});

prggmr\listen(new User());

prggmr\handle('hello_world', function(){
    $this->a++;
    echo "HelloWorld2".PHP_EOL;
});

// Inject into the event before the on_load method is called!
prggmr\signal_interrupt("load", function(){
    $this->db = "MY DB";
    $this->injected = "Some real shit";
});

prggmr\signal('hello_world');

prggmr\signal('load');