<?php
namespace prggmr\module\socket\event;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Disconnect
 * 
 * Socket disconnection.
 */
class Disconnect extends Base {

    /**
     * Cannot disconnect a disconnect.
     *
     * @return  void
     */
    public function disconnect(/* ... */)
    {
        throw new \LogicException(sprintf(
            "Socket %s is already disconnected",
            $this->get_address()
        ));
    }

}