<?php
namespace prggmr\module\socket\event;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Socket disconnection event.
 */
class Disconnect extends Connect {

    /**
     * Cannot disconnect a disconnect.
     *
     * @throws  LogicException
     * 
     * @return  void
     */
    public function disconnect()
    {
        throw new \LogicException(sprintf(
            "Socket %s is already disconnected",
            stream_socket_get_name($this->get_socket(), true)
        ));
    }

}