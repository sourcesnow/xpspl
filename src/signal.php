<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \InvalidArgumentException;

/**
 * As of v0.3.0 the default signal object allows for signals of only strings
 * and integers. 
 * 
 * Other signal types are considered "complex" and use the 
 * \XPSPL\signal\Complex object.
 */
class Signal extends \XPSPL\signal\Standard {

    /**
     * Unique signal object.
     *
     * @var  boolean
     */
    protected $_unique = false;
    

    /**
     * Constructs a new signal.
     *
     * @param  string|integer  $info  Signal information
     *
     * @return  void
     */
    public function __construct($info = null)
    {
        if (null === $info || !is_int($info) && !is_string($info)) {
            if ($this->_unique) {
                $info = spl_object_hash($this);
            } else {
                $info = get_class($this);
                if ($info === 'XPSPL\Signal') {
                    throw new \InvalidArgumentException;
                }
            }
        }
        $this->_info = $info;
    }
}