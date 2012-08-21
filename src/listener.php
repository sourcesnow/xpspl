<?php
namespace prggmr;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
 
/**
 * The listener allows for register itself in the engine and having the engine
 * trigger the given methods within the object when they are signled.
 */
class Listener {

    /**
     * Class members.
     */
    protected $_sig_handlers = [];

    /**
     * Constructs the listener.
     *
     * @return  void
     */
    public function __construct()
    {
        foreach (get_class_methods($this) as $_method) {
            // skip magic methods
            if (stripos('_', $_method) === 0) continue;
            if (stristr($_method, 'on_') === false) continue;
            if (isset($this->$_method)) {
                $_signal = eval($this->{$_method});
            } else {
                $_signal = str_replace('on_', '', $_method);
            }
            $this->_sig_handlers[] = [
                $_method,
                $_signal
            ];
        }
    }

    /**
     * Returns the sig handlers for this listener.
     *
     * @return  array
     */
    public function get_signal_handlers(/* ... */)
    {
        return $this->_sig_handlers;
    }
}