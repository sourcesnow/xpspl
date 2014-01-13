<?php
namespace ftp;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * SIG_Finished
 *
 * Emitted when an upload finishes.
 */
class SIG_Finished extends \XPSPL\SIG {

    /**
     * Make the signal unique
     */
    protected $_unique = true;

    /**
     * FTP SIG that was uploaded.
     */
    protected $_ftp_sig = null;

    /**
     * Construct new finished signal.
     *
     * @param  object  \ftp\SIG_Upload
     */
    public function __construct(\ftp\SIG_Upload $sig_upload, $index = null) {
        $this->_ftp_sig = $sig_upload;
        parent::__construct($index);
    }

}