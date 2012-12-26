<?php
namespace xpspl\engine\idle;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Idles the engine using a function.
 */
class Func extends \xpspl\engine\Idle 
{
    /**
     * Priority of this idle function.
     *
     * @var  integer
     */
    protected $_priority = 1;

    /**
     * Function to run for the idle.
     *
     * @var  boolean
     */
    protected $_function = true;
    

    /**
     * Constructs the time idle.
     */
    public function __construct($function)
    {
        if (!is_callable($function)) {
            throw new \InvalidArgumentException(
                "Invalid idle function"
            );
        }
        $this->_function = $function;
    }

    /**
     * Run the idle function.
     */
    public function idle($engine) 
    {
        return call_user_func_array($this->_function, [$engine]);
    }
}
