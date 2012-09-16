<?php

prggmr\load_module('time');

/**
 * This demonstrates prggmr's ability to perform CPE using the example 
 * taking from Wikipedia of a wedding taking place.
 */
class Wedding extends \prggmr\signal\Complex {

    protected $_signals = array(
        'man',
        'woman',
        'bells'
    );

    public function routine($history) 
    {
        $man = false;
        $woman = false;
        $bells = false;
        foreach ($history as $_node) {
            if ($node[1] instanceof \prggmr\signal\Complex) continue;
            if ($_node[1] instanceof \prggmr\Signal) {
                $sig = $_node[1]->info();
            } else {
                $sig = $_node[1];
            }
            if (in_array($sig, $this->_signals)) {
                switch($sig) {
                    case 'man':
                        $man = true;
                        break;
                    case 'woman':
                        $woman = true;
                        break;
                    case 'bells':
                        $bells = true;
                        break;
                }
            }
        }
        if ($man && $woman && $bells) {
            return $this->signal_this();
        }

        return false;
    }

}

// signal handlers

// When the wedding takes places
prggmr\handle(new Wedding(), function(){
    echo "A wedding is taking place!".PHP_EOL;
    // A little later the wedding ends
    prggmr\module\time\timeout(10000, function(){
        prggmr\signal('wedding_over');
    });
});

// When the man arrives
prggmr\handle('man', function(){
    echo "The man has arrived".PHP_EOL;
});

// When the woman arrives
prggmr\handle('woman', function(){
    echo "The woman has arrived".PHP_EOL;
});

// When the bells ring
prggmr\handle("bells", function(){
    echo "Wedding bells Ringing".PHP_EOL;
});

// When the wedding is over
prggmr\handle('wedding_over', function(){
    echo "The wedding is over".PHP_EOL;
});

// man arrives late because of second thoughts
prggmr\module\time\timeout(5000, function(){
    prggmr\signal('man');
});

// couple seconds after he arrives the bells start ringing
prggmr\module\time\timeout(10000, function(){
    prggmr\signal('bells');
});

// Woman is ready first
prggmr\signal('woman');