<?php
namespace xpspl\socket\signal;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Base
 * 
 * Base socket signal.
 */
class Base extends \xpspl\Signal {

    /**
     * Constructs a new socket signal.
     *
     * @param  object  $connection  Socket connection object
     */
    public function __construct($connection = null)
    {
        parent::__construct();

        if (null === $info) {
            return;
        }

        $this->_info = spl_object_hash($signal).$this->_info;
    }
}