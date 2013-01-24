<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Generates an XPSPL SIG object.
 *
 * This function is literally a shorthand to avoid typing new SIG.
 *
 * @param  string|  $signal  Signal process is attached to.
 * 
 * @return  object  \XPSPL\SIG
 *
 * @example
 *
 * Passing a signal to the ``signal`` function.
 *
 * .. code-block::php
 *
 *    <?php
 *    signal(SIG('foo'), function(){
 *        echo "HelloWorld";
 *    });
 *    
 *    emit(SIG('foo'));
 */
function SIG($signal)
{
    return new \XPSPL\SIG($signal);
}