<?php
namespace prggmr\engine\signal;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * Catches all engine error signals that trigger.
 */
class Engine_Errors extends \prggmr\signal\Complex {

    public function evaluate($signal)
    {
        echo "HERE";
        if ($signal instanceof Error) {
            return true;
        }
        return false;
    }

}