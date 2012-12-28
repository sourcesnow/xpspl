<?php
namespace unittest;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * API can be included to load the entire signal.
 */

/**
 * Add a new assertion function.
 * 
 * @param  closure  $function  Assertion function
 * @param  string  $name  Assertion name
 * @param  string  $message  Message to return on failure.
 * 
 * @return  void
 */
function create_assertion($function, $name, $message = null) {
    return \xpspl\unittest\Assertions::instance()->create_assertion($function, $name, $message);
}

/**
 * Creates a new test case.
 * 
 * @param  object  $function  Test function
 * @param  string  $name  Test name
 * @param  object  $event  xpspl\unittest\Event
 * 
 * @return  array  [Handle, Signal]
 */
function test($function, $name = null, $event = null) {
    $signal = new \xpspl\unittest\Test($name, $event);
    $handle = signal($signal, $function);
    return [$handle, $signal];
}

/**
 * Constructs a new unit testing suite.
 * 
 * @param  object  $function  Closure
 * @param  object|null  $event  xpspl\unittest\Event
 * 
 * @return  void
 */
function suite($function, $event = null) {
    return new \xpspl\unittest\Suite($function, $event);
}

/**
 * Registers a standard output mechanism for test results.
 * 
 * @return  void
 */
function generate_output() {

    // enable the event history
    save_signal_history(true);

    // Startup
    on_start(function(){
        define('UNITTEST_START_TIME', milliseconds());
    });

    // Shutdown
    on_shutdown(function(){
        define('UNITTEST_END_TIME', milliseconds());
        $tests = 0;
        $pass = 0;
        $fail = 0;
        $skip = 0;
        $output = \xpspl\unittest\Output::instance();
        $tests_run = [];
        foreach (signal_history() as $_node) {
            if ($_node[0] instanceof \xpspl\unittest\Event) {
                // suites
                $tests++;
                if (in_array($_node[0], $tests_run)) continue;
                $tests_run[] = $_node[0];
                $failures = [];
                // Get passedxpspl 
                foreach ($_node[0]->get_assertion_results() as $_assertion) {
                    if ($_assertion[0] === true) {
                        $pass++;
                    } elseif ($_assertion[0] === null) {
                        $skip++;
                    } else {
                        $fail++;
                        $failures[] = $_assertion;
                    }
                }

                if (count($failures) != 0) {
                    $output->send_linebreak(\xpspl\unittest\Output::ERROR);
                    foreach ($failures as $_failure) {
                        $output->send("FAILURE", \xpspl\unittest\Output::ERROR);
                        $output->send("ASSERTION : " . $_failure[1], \xpspl\unittest\Output::ERROR, true);
                        $output->send("MESSAGE : " . $_failure[0], \xpspl\unittest\Output::ERROR, true);
                        $output->send(sprintf(
                            'ARGUMENTS : %s',
                            $output->variable($_failure[2])
                        ), \xpspl\unittest\Output::ERROR, true);
                        $trace = $_failure[3][1];
                        $output->send("FILE : " . $trace["file"], \xpspl\unittest\Output::ERROR, true);
                        $output->send("LINE : " . $trace["line"], \xpspl\unittest\Output::ERROR);
                        $output->send_linebreak(\xpspl\unittest\Output::ERROR);
                    }
                }
            }
        }
        $size = function($size) {
            /**
             * This was authored by another individual by whom i don't know
             */
            $filesizename = array(
                " Bytes", "KB", "MB", "GB", 
                "TB", "PB", " EB", "ZB", "YB"
            );
            return $size ? round(
                $size/pow(1024, ($i = floor(log($size, 1024)))), 2
            ) . $filesizename[$i] : '0 Bytes';
        };
        $output->send_linebreak();
        $output->send(sprintf(
            "Ran %s tests in %sms and used %s memory", 
            $tests,
            UNITTEST_END_TIME - UNITTEST_START_TIME,
            $size(memory_get_peak_usage())
        ), \xpspl\unittest\Output::SYSTEM, true);

        $output->send(sprintf("%s Assertions: %s Passed, %s Failed, %s Skipped",
            $pass + $fail + $skip,
            $pass, $fail, $skip
        ), \xpspl\unittest\Output::SYSTEM, true);

    });
}