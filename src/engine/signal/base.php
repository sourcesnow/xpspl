<?php
namespace prggmr\engine\signal;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * The base any engine signal.
 */
class Base extends \prggmr\Signal {
    
    /**
     * Returns the information for this signal.
     */
    public function info()
    {
        return 'prggmr_'.strtolower(get_class($this));
    }
}