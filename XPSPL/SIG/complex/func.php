<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
namespace XPSPL\SIG\complex;

/**
 * Func
 *
 * Allows for performing complex signal processing using \\Closures and callable 
 * PHP variables provided in the construct.
 *
 * A ``\\Closure`` can be rebound into the Func object context on construct which 
 * allows maintaining variables across emits.
 *
 * This object was created for use in the API.
 *
 * @example
 *
 * Example #1 Detecting a wedding.
 *
 * .. code-block:: php
 *
 *     <?php
 *     // Once a bride, groom and bell signals are emitted we emit the wedding.
 *     $complex_sig = xp_complex_sig(function($signal){
 *         if (!isset($this->reset) || $this->reset) {
 *             $this->reset = false;
 *             $this->bride = false;
 *             $this->groom = false;
 *             $this->bells = false;
 *         }
 *         switch (true) {
 *             case $signal === XP_SIG('groom'):
 *                 $this->groom = true;
 *                 break;
 *             case $signal === XP_SIG('bride');
 *                 $this->bride = true;
 *                 break;
 *             case $signal === XP_SIG('bells');
 *                 $this->bells = true;
 *                 break;
 *         }
 *         if ($this->groom && $this->bride && $this->bells) {
 *             $this->reset = true;
 *             return true;
 *         }
 *         return false;
 *     });
 */
class Func extends \XPSPL\SIG_Complex {

	/**
	 * Function to evaluate the emitting signal.
	 * 
	 * @var  callable
	 */
	protected $_function = null;

	/**
	 * Construct
	 *
	 * Constructs a Func object.
	 *
	 * Allows for rebinding a \\Closure to the Func object context for 
	 * maintaining variables across emits.
	 *
	 * @param  callable  $function  Callable variable to use for evaluation.
	 * @param  boolean  $rebind_context  Rebind the given closures context to 
	 *                                   this object.
	 */
	public function __construct($function, $rebind_context = false)
	{
		if (!is_callable($function)) {
			throw new \InvalidArgumentException;
		}
		if ($rebind_context) {
			$function = $function->bindTo($this);
		}
		$this->_function = $function;
	}

	/**
     * Evaluates the emitted signal by calling the $_evaluate_func function.
     *
     * @param  string|integer  $signal  Signal to evaluate
     *
     * @return  boolean
     */
    public function evaluate($signal = null) 
    {
    	return call_user_func($this->_function, $signal);
    }

}