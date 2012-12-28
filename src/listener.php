<?php
namespace xpspl;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
 
/**
 * Listener 
 *
 * Added in v2.0.0
 * 
 * The listener allows for registering a class into the processor establishing 
 * handles for each publicly defined method name.
 */
class Listener {

    /**
     * Signals to listen for.
     */
    protected $_signals = [];

    /**
     * Constructs the listener.
     *
     * @return  void
     */
    public function __construct(/* ... */)
    {
        foreach (get_class_methods($this) as $_signal) {
            // skip magic methods
            if (stripos($_signal, '_') === 0) {
                continue;
            }
            if (isset($this->$_signal)) {
                $_signal = eval($this->{$_signal});
            }
            $this->_signals[] = $_signal;
        }
    }

    /**
     * Returns the sig handlers for this listener.
     *
     * @return  array
     */
    public function _get_signals(/* ... */)
    {
        return $this->_signals;
    }
}