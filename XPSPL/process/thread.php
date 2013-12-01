<?php

namespace XPSPL\process;

/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * A Threaded process.
 * 
 */
class Thread extends \Thread {

	protected $_callable = null;

	public function __construct($callable) {
		$this->_callable = $callable;
	}

	public function run() 
	{
		if (is_array($this->_callable)) {
            if (count($this->_callable) >= 2) {
                if (is_object($this->_callable[0])) {
                	$this->_callable[0]->$this->_callable[1](current_signal());
                } else {
                    (new $this->_callable[0])->$this->_callable[1](current_signal());
                }
            }
            $this->_callable[0](current_signal());
        }
        var_dump(current_signal());
        $this->_callable(current_signal());
	}

	/**
     * Return a string representation of this thread.
     *
     * @return  string
     */
    public function __toString(/* ... */)
    {
        return sprintf('CLASS(%s) - HASH(%s) - THREAD(%s) MAIN(%s)',
            get_class($this), 
            spl_object_hash($this),
            $this->getThreadId(),
            $this->getCreatorId()
        );
    }

}