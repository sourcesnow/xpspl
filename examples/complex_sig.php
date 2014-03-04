<?php

// Create our 3 required signals.
class SIG_Bells extends \XPSPL\SIG {}
class SIG_Bride extends \XPSPL\SIG {}
class SIG_Groom extends \XPSPL\SIG {}

// Create a complex signal that will emit when a wedding takes place
// based on 3 seperate signals, SIG_Bells, SIG_Bride and SIG_Groom.
class SIG_Wedding extends \XPSPL\SIG_Complex {

    // Keep track if each requirement has already emitted
    protected $_bells = false;
    protected $_bride = false;
    protected $_groom = false;

    // Create an evaulation method to evaluate the runtime
    public function evaluate($signal = null)
    {
        switch ($signal) {
            case $signal instanceof SIG_Bells:
                $this->_bells = true;
                break;
            case $signal instanceof SIG_Bride:
                $this->_bride = true;
                break;
            case $signal instanceof SIG_Groom:
                $this->_groom = true;
                break;
        }
        if ($this->_bells === true &&
                $this->_bride === true &&
                $this->_groom === true) {
            $this->_bells = false;
            $this->_groom = false;
            $this->_bride = false;
            return true;
        }
        return false;
    }
}

// Install a process for complex signal.
xp_signal(new SIG_Wedding(), function(){
    echo 'The wedding is happening!'.PHP_EOL;
});

// Emit SIG_Bells, SIG_Bride and SIG_Groom
xp_emit(new SIG_Bells());
xp_emit(new SIG_Bride());
xp_emit(new SIG_Groom());