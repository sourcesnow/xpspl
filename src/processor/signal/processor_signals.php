<?php
namespace XPSPL\processor\signal;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * Catches all processor signals that trigger.
 */
class Processor_Signals extends \XPSPL\signal\Complex {

    public function evaluate($signal = null)
    {
        if ($signal instanceof Base) {
            return true;
        }
        return false;
    }

}