<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers a function to call when the processor shuts down.
 *
 * @param  callable|object  $function  Function or process object
 *
 * @return  object  \XPSPL\Process
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     xp_on_shutdown(function(){
 *         echo 'Shutting down the processor!';
 *     });
 *
 *     xp_wait_loop();
 *
 * The above code will output.
 *
 * .. code-block:: php
 *
 *     Shutting down the processor!
 */
function xp_on_shutdown($function)
{
    return xp_signal(new \XPSPL\processor\SIG_Shutdown(), $function);
}