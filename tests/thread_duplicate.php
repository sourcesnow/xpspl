<?php
namespace test;
if (class_exists('\\Thread')) {

class Thread extends \Thread {

    public $_callable = '';

    public function __construct($callable) 
    {
        $this->_callable = $callable;
    }

    public function run() 
    {
        call_user_func($this->_callable);
    }

}

class Process {
    public function __construct()
    {
        $this->_callable = [$this, 'execute'];
    }
    public function execute()
    {
        echo 'SLEEPING';
        sleep(10);
        echo 'DONE SLEEPING';
    }
    public function make_thread()
    {
        $this->_callable = new Thread($this->_callable);
    }
    public function get_function()
    {
        return $this->_callable;
    }
}

$process_list = [];
$process = new Process();
$process->make_thread();
$process_list[] = $process->get_function();
$process_list[] = clone $process->get_function();
reset($process_list)->start();
end($process_list)->start();
end($process_list)->join();
reset($process_list)->start();
}