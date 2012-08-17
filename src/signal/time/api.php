<?php
namespace prggmr\signal\time;

/**
 * Calls a function at the specified intervals of time.
 *
 * @param  integer  $interval  Time between the interval.
 * @param  callable  $callable  Callable variable.
 * @param  array  $instruction  The time instruction. Default = Milliseconds
 *
 * @return  array  [signal, handle]
 */
function interval($interval, $callable, $instruction = \prggmr\engine\idle\Time::MILLISECONDS)
{
    $signal = new Interval($interval, $instruction);
    if (!$callable instanceof \prggmr\Handle) {
        $callable = new \prggmr\Handle($callable, 0);
    }
    $handle = \prggmr::instance()->handle($signal, $callable);
    return [$signal, $handle];
}

/**
 * Calls a function after the specified timeout.
 *
 * @param  integer  $timeout  Amount of time to wait.
 * @param  callable  $callable  Callable variable.
 * @param  array  $instruction  The time instruction. Default = Milliseconds
 *
 * @return  array  [signal, handle]
 */
function timeout($timeout, $callable, $instruction = \prggmr\engine\idle\Time::MILLISECONDS)
{
    $signal = new Timeout($timeout, $instruction);
    if (!$callable instanceof \prggmr\Handle) {
        $callable = new \prggmr\Handle($callable, 1);
    }
    $handle = \prggmr::instance()->handle($signal, $callable);
    return [$signal, $handle];
}


/**
 * Setup a cron based signal.
 *
 * @param  string  $expression  Cron expression
 * @param  callable  $callable  Callable variable.
 *
 * @return  array  [signal, handle]
 */
function cron($expression, $callable) {
    $signal = new Cron($expression);
    if (!$callable instanceof \prggmr\Handle) {
        $callable = new \prggmr\Handle($callable, 1);
    }
    $handle = \prggmr\handle($signal, $callable);
    return [$signal, $handle];
}
