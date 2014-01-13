<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

define('FTP_VERSION', '1.0.0');

$dir = dirname(realpath(__FILE__));
$required = [
    'api', 'file', 'sig_base', 'sig_complete', 'sig_finished', 'sig_failure',
    'sig_upload'
];
foreach ($required as $_r) {
    require_once $dir.'/src/'.$_r.'.php';
}