<?php
namespace unittest;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\SIG_Complex;

/**
 * A test suite.
 * 
 * The suite is designed to run a group of tests together.
 */
class SIG_Suite extends SIG_Complex {

    /**
     * Test context used in the suite.
     * 
     * @var  object  unittest\SIG_Test
     */
    protected $_test = null;

    /**
     * Setup function.
     * 
     * @var  object  \Closure
     */
    protected $_setup = null;

    /**
     * Teardown function
     * 
     * @var  object  Closure
     */
    protected $_teardown = null;

    /**
     * Constructs a new unit testing suite.
     * 
     * @param  object  $function  Closure
     * 
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_test = new SIG_Test();
    }

    /**
     * Registers the setup function.
     * 
     * @param  object  $function  Closure
     * 
     * @return  void
     */
    public function setup($function)
    {
        if (!$function instanceof \Closure) {
            throw new \InvalidArgumentException(
                "Suite requires instance of a Closure"
            );
        }
        $this->_setup = null_exhaust($function);
    }

    /**
     * Registers the teardown function.
     * 
     * @param  object  $function  Closure
     * 
     * @return  void
     */
    public function teardown($function)
    {
        if (!$function instanceof \Closure) {
            throw new \InvalidArgumentException(
                "Suite requires instance of a Closure"
            );
        }
        $this->_teardown = null_exhaust($function);
    }

    /**
     * Creates a new test case in the suite.
     * 
     * @param  object  $function  Test function
     * @param  string  $name  Test name
     */
    function test($function, $name = null) {
        $signal = new SIG_Test($name);
        $this->_routine->add_signal(
            $signal, $this->_test
        );
        $process = signal($signal, $function);
        if (null !== $this->_setup) {
            before(
                $signal, $this->_setup
            );
        }
        if (null !== $this->_teardown) {
            after(
                $signal, $this->_teardown
            );
        }
        return [$signal, $process];
    }

    /**
     * Routine function
     */
    public function routine($history = null)
    {
        $this->signal_this();
        return true;
    }
}