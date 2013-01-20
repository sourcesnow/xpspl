<?php
namespace unittest;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\SIG;

if (!defined('SKIP_TESTS_ON_FAILURE')) {
    define('SKIP_TESTS_ON_FAILURE', true);
}

/**
 * Unit testing signal
 * 
 * This allows for unit testing using signals.
 * 
 * Testing is performed as:
 * 
 * XPSPL\unit_test\api\test(function(){
 *     $this->true(true);
 *     $this->false(false);
 *     $this->null(null);
 *     etc ...
 * });
 */
class SIG_Test extends SIG {

    protected $_unique = true;

    /**
     * Assertion tests ran.
     */
    protected $_assertions_ran = []; 

    /**
     * Assertions run and their results.
     */
    protected $_assertion_results = [];

    /**
     * Quick indication of a failure.
     */
    protected $_failed = false;

    /**
     * Constructs a new test signal.
     * 
     * @param  string  $name  Name of the test.
     * 
     * @return  void
     */
    public function __construct($info = null)
    {
        $this->_info = $info;
        parent::__construct();
    }

    /**
     * Calls an assertion function.
     * 
     * @return  boolean  true
     */
    public function __call($func, $args)
    {
        $this->_assertions_ran[] = $func;
        if ($this->_failed && SKIP_TESTS_ON_FAILURE) {
            Output::instance()->assertion($this, $func, $args, null);
            return false;
        } else {
            try {
                $call = Assertions::instance()->call_assertion($func, $args, $this);
            } catch (\BadMethodCallException $e) {
                $call = null;
                Output::instance()->unknown_assertion(
                    $this, $func, $args, $this->_assertions
                );
            }
            if ($call !== true) {
                $this->_failed = true;
            }
            Output::instance()->assertion($this, $func, $args, $call);
        }
        // Add call to results
        $this->_assertion_results[] = [
            $call, $func, $args, debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)
        ];
        return $call;
    }

    /**
     * Returns the assertion results.
     * 
     * @return  array
     */
    public function get_assertion_results()
    {
        return $this->_assertion_results;
    }

    /**
     * Returns the assertions run.
     * 
     * @return  array
     */
    public function get_assertions_ran()
    {
        return $this->_assertions_ran;
    }

    /**
     * Checks if the test failed.
     * 
     * @return  boolean
     */
    public function failed()
    {
        return $this->_failed;
    }

    /**
     * Sets X number of assertions skipped.
     *
     * @param  integer  $number  Number of assertions skipped
     *
     * @return  void
     */
    public function mark_skipped_assertions($number = 1)
    {
        for ($i=0;$i<$number;$i++) {
            Assertions::instance()->assertion($this, null, null, null);
        }
    }
}