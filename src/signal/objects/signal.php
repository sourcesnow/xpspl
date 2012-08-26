<?php
namespace prggmr\signal\objects;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * The base any engine signal.
 */
class Signal extends \prggmr\Signal {
    
    /**
     * Sets the information as the class name.
     */
    public function __construct() {
        $this->_info = strtolower(get_class($this));
    }
}