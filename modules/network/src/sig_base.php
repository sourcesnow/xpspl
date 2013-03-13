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
class SIG_Base extends \XPSPL\SIG {

    public $socket = null;

    /**
     * Socket signals use the connection and socket hash
     * 
     * @return  void
     */
    public function __construct($info = null, $socket = null)
    {
        if (null !== $socket) {
            $this->socket = $socket;
        }
        if (null === $info) {
            parent::__construct();
            return;
        }
        $this->_info = spl_object_hash($info).'.'.get_class($this);
    }

}