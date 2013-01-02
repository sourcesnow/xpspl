<?php
namespace network;
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
class SIG_Base extends \XPSPL\Signal {

    /**
     * Socket signals use the connection and socket hash
     * 
     * @return  void
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