<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Begin the XPSPL wait loop.
 *
 * The XPSPL wait loop is a core function of XPSPL and *MUST* be called as the 
 * final function to execute any type of complex event, this includes time, 
 * networking and ftp operations.
 *
 * @return  void
 *
 * .. warning::
 *
 *    This is a *BLOCKING* function.
 *
 *    A loop based signal time, networking, ftp ... etc must be registered 
 *    before calling the wait_loop.
 *
 *    Any code underneath the function call will *NOT* be executed until 
 *    the processor halts execution.
 *
 *
 * @example
 *
 * Basic Usage
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
 *    xp_wait_loop()
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