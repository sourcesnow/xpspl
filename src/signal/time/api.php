<?php
namespace prggmr\signal\time;

/**
 * Calls a function at the specified intervals of time in milliseconds.
 *
 * @param  object  $function  Closure
 * @param  integer  $timeout  Milliseconds before calling timeout.
 * @param  array  $instruction  The time instruction
 * @param  object  $event 
 *
 * @return  array  [signal, handle]
 */
function interval($interval, $function, $instruction = \prggmr\engine\idle\Time::MILLISECONDS)
{
    $signal = new Interval($interval, $instruction);
    $handle = \prggmr::instance()->handle($function, $signal);
    return [$signal, $handle];
}

/**
 * Calls a timeout function after the specified time in microseconds.
 * 
 * @param  object  $function  Closure
 * @param  integer  $timeout  Milliseconds before calling timeout.
 * @param  array  $instruction  The time instruction
 *
 * @return  array  [signal, handle]
 */
function timeout($function, $timeout, $instruction = \prggmr\engine\idle\Time::MILLISECONDS)
{
    $signal = new Timeout($timeout, $instruction);
    $handle = \prggmr::instance()->handle($function, $signal);
    return [$signal, $handle];
}


/**
 * Setup a cron based signal.
 *
 * @param  callable  $function  Function to call
 * @param  string  $expression  Cron expression
 *
 * @return  array  [signal, handle]
 */
function cron($function, $expression) {
    $signal = new Cron($expression);
    $handle = \prggmr\handle($signal, $function);
    return [$signal, $handle];
}
