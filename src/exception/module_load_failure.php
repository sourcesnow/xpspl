<?php
namespace XPSPL\exception;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * Module load failure
 * 
 * An attempted module load failed.
 *
 * This is generated immediately after php_declare(import).
 */
class Module_Load_Failure extends \Exception {}