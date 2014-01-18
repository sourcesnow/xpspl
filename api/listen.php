<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers a new object listener.
 *
 * @param  object  $listener  The event listening object
 *
 * @return  void
 */
function xp_listen($listener)
{
    return XPSPL::instance()->listen($listener);
}