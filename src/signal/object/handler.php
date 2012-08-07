<?php
namespace prggmr\signal\object;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
 
 /**
 * Handle signals using the methods of an object.
 */
class Listener extends \prggmr\signal\Complex {

    /**
     * Class members.
     */
    protected $_methods = [];

    /**
     * Constructs the sig handler.
     *
     * @return  void
     */
    public function __construct($engine = null)
    {
        foreach (get_class_methods($this) as $_method) {
            // skip magic methods
            if (stripos('_', $_method) === 0) continue;
            $this->_methods[] = $_method;
        }
    }

    /**
     * Evalutes the signal with the object's methods.
     *
     * @param  mixed  $signal  Signal to perform regex aganist.
     *
     * @return  boolean|array  Boolean|Array if matches found
     */
    public function evaluate($signal = null)
    {
        return false;
    }
}