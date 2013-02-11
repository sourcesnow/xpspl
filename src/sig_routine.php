<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\processor\exception\Not_Implemented;

/**
 * SIG_Routine
 *
 * @since 2.0.0
 *
 * A SIG_Routine object indicates to the processor a routine that must be run.
 *
 * Each routine is ran at the beginning of the loop.
 * 
 * It allows for giving the processor the following information.
 *
 * - Signals to emit
 * - How to idle until the next loop
 *
 * SIG_Routines are designed for signals that will need to idle the processor 
 * to wait for emitting in the future.
 */
abstract class SIG_Routine extends SIG {

    protected $_unique = true;

    /**
     * Runs the routine calculation.
     *
     * The method is provided a single routine object for providing the 
     * processor information.
     *
     * @param  object  $routine  Processor routine.
     * 
     * @return  void
     */
    abstract public function routine(Routine $routine);
}