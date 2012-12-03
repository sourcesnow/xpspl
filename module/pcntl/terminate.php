<?php
namespace prggmr\module\pcntl;
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
  * Allow for handling script termination.
  */
class Terminate extends Signal
{
    protected $_signal = SIGTERM;
}