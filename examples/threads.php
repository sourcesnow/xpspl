<?php

$max_threads = 16 - 1;

class My_Thread extends \XPSPL\Process
{
    public function execute($signal, $thread)
    {
        while(true) {
            var_dump($thread);
        }
    }
}

for ($i = 0; $i < $max_threads; $i++) {
    xp_signal(XP_SIG('test'.$i), xp_threaded_process(new My_Thread()));
}
for ($i = 0; $i < $max_threads; $i++) {
    xp_emit(XP_SIG('test'.$i));
}
