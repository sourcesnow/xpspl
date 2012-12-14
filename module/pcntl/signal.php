<?php
namespace prggmr\pcntl;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
 if (!function_exists('pcntl_signal')) {
    throw new RuntimeException(
        'pcntl interrupt signal requires the pcntl module to be loaded'
    );
}
 /**
  * Allow for handling script interruption.
  */
class Signal extends \prggmr\signal\Complex 
{
    /**
     * The system signal to catch.
     * 
     * @var  int
     */
    protected $_sig = null;
    
    public function __construct($engine = null) {
        pcntl_signal(SIGTERM, function() use ($engine){
            if (null === $engine) {
                \prggmr\signal($this);
            } else {
                $engine->signal($this);
            }
            exit(0);
            return true;
        });
    }
}