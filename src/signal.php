<?php
namespace xpspl;
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
 * \xpspl\signal\Complex object.
 */
class Signal extends \xpspl\signal\Standard {

    /**
     * Unique signal object.
     *
     * @var  boolean
     */
    protected $_unique = false;
    

    /**
     * Constructs a new standard signal.
     *
     * @param  string|integer  $info  Signal information
     *
     * @return  void
     */
    public function __construct($info = null)
    {
        if (null === $info || !is_int($info) && !is_string($info)) {
            $info = strtolower(get_class($this));
            if ($info == 'xpspl\signal') {
                throw new \InvalidArgumentException;
            }
            if ($this->_unique) {
                $info = spl_object_hash($this);
            }
        }
        $this->_info = $info;
    }
}