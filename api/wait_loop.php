<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Begins the XPSPL event wait loop.
 *
 * The event loop must be started to allow execution of time, networking or 
 * complex loop based signals.
 *
 * .. note:: 
 *
 *    XPSPL provides an executable ``xpspl`` in the *bin* directory for 
 *    automatically loading code into the event loop.
 *
 * .. warning::
 *
 *    This is a *BLOCKING* function.
 *
 *    Any code underneath the function call will *NOT* be executed until 
 *    the processor halts execution.
 *
 * @return  void
 *
 * @example
 *
 * Example #1 Basic Usage
 *
 * Basic usage example demonstrating using the loop for time based code.
 *
 * .. code-block:: php
 *
 *    <?php
 *
 *    // Import time module
 *    xp_import('time');
 *
 *    xp_time\awake(10, function(){
 *        echo '10 seconds passed';
 *    });
 *
 *    xp_wait_loop();
 *
 * @example
 *
 * Automatic shutdown
 *
 * The processor loop has built in support for automatically shutting down when 
 * it detects there is nothing else it will ever do.
 *
 * This example demonstrates the loop shutting down after emitting 5 time based 
 * signals.
 *
 * .. code-block:: php
 * 
 */
function xp_wait_loop()
{
    return XPSPL::instance()->wait_loop();
}