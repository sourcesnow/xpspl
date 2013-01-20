<?php
namespace \XPSPL;
/**
 * LICENSE
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
class SIG_Routine extends SIG {

    /**
     * Runs the routine calculation.
     *
     * The method is provided a single routine object for providing the 
     * processor information.
     *
     * As of v3.0.0 the history was removed as a passed paramter.
     *
     * @param  object  $routine  Processor routine.
     * 
     * @return  void
     */
    public function routine(Routine $routine) {
        throw new Not_Implemented();
    }

}