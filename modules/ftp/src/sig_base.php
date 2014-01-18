<?php
namespace ftp;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * SIG_Base
 *
 * Used as the base for upload and complete FTP signals.
 */
abstract class SIG_Base extends \XPSPL\SIG {

    /**
     * FTP Transfers are unique.
     */
    protected $_unique = true;

    /**
     * SIG_Upload object
     */
    protected $_upload = null;

    /**
     * Sets the file uploaded.
     *
     * @param  object  $upload  Upload object
     *
     * @return  void
     */
    public function set_upload($upload)
    {
        $this->_upload = $upload;
    }

    /**
     * Returns the upload that finished.
     *
     * @return  object
     */
    public function get_upload(/* ... */)
    {
        return $this->_upload;
    }

    /**
     * Returns the uploaded file.
     *
     * @return  object  \ftp\File
     */
    public function get_file(/* ... */)
    {
        return $this->get_upload();
    }
}