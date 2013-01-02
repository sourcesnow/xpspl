<?php
namespace XPSPL\pcntl;
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
class Signal extends \XPSPL\signal\Complex 
{
    /**
     * The system signal to catch.
     * 
     * @var  int
     */
    protected $_sig = null;
    
    public function __construct($processor = null) {
        pcntl_signal(SIGTERM, function() use ($processor){
            if (null === $processor) {
                \XPSPL\signal($this);
            } else {
                $processor->signal($this);
            }
            exit(0);
            return true;
        });
    }
}