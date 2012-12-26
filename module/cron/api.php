<?php
namespace xpspl;

use xpspl\cron\Signal;

/**
 * Setup a cron based signal.
 *
 * @param  string  $expression  Cron expression
 * @param  callable  $callable  Callable variable.
 *
 * @return  array  [signal, handle]
 */
function cron($expression, $callable) {
    $signal = new Signal($expression);
    if (!$callable instanceof \xpspl\Handle) {
        $callable = new \xpspl\Handle($callable, null);
    }
    $handle = \xpspl\handle($signal, $callable);
    return [$signal, $handle];
}