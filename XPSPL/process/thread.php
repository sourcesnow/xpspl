<?php
namespace {
if (!class_exists('\\Thread')) {
    // used for the docs ...
    class Thread {}
}
}

namespace XPSPL\process {

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

	public $_callable = '';

	public function __construct(\XPSPL\Process $process)
    {
        $this->_callable = $process->get_function();
	}

	public function run()
	{

        call_user_func_array($this->_callable, [null, $this]);
        // if (is_array($callable)) {
        //     if (count($callable) >= 2) {
        //         if (is_object($callable[0])) {
        // var_dump($this);
        // $callable[0]->$callable[1]();
        //         } else {
        //             (new $callable[0])->$callable[1](current_signal());
        //         }
        //     }
        //     $callable[0](current_signal());
        // } else {
        //     $this->callable(current_signal());
        // }
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

    public function __clone()
    {
        $this->_callable = $this->_callable;
    }

}

}