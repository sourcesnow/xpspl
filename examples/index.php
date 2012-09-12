<?php
require '../src/prggmr.php';
echo '<pre>';
/**
 * This must run directly in your browser!
 * 
 * Use the php built server:
 * php -S 127.0.0.1:5000 index.php
 */

/**
 * Load the http signal library
 */
prggmr\load_module('http');

// Shorten namespace down
use prggmr\module\http as http;
/**
 * Route to /
 */
prggmr\signal_interrupt('prggmr\module\http\Uri', function(){
    $this->db = new stdClass();
    // echo "Here";
    return false;
}, null, true);

http\api\uri_request("/", function(){
    echo "Hello World";
    var_dump($this->db);
});

http\api\uri_request(['/dashboard/:param', ['param' => '.*']], function(){
    echo 1111;
});

http\api\uri_request('/dashboard', function(){
    echo "At the dashboard";
});

/**
 * Route to /user/:name
 */
prggmr\signal_interrupt(new http\Uri("/user/:name"), function($name){
    echo "Performing pre-handle action on $name";
}, null, null, true);

http\api\uri_request("/user/:name/:dog", function($name, $dog){
    echo "WHAT ".$this->name . " ". $this->dog;
});

http\api\uri_request("/user/:name", function(){
    echo "Hello ".$this->name;
});

/**
 * Route to /admin/:id
 * 
 * Cancel stack in interrupt if $_GET['auth'] is not set
 */
prggmr\signal_interrupt(new http\Uri("/admin/:id"), function(){
    if (!isset($_GET['auth'])) {
        echo "You do not have permission to view ".$this->id;
        $this->halt();
    } else {
        echo $_GET['auth'];
    }
});

http\api\uri_request("/admin/:id", function(){
    echo "Viewing ".$this->id;
});

prggmr\loop();