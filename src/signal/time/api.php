<?php
namespace prggmr\signal\time;

/**
 * Calls a function at the specified intervals of time in milliseconds.
 *
 * @param  object  $function  Closure
 * @param  integer  $timeout  Milliseconds before calling timeout.
 * @param  array  $vars  Variables to pass the timeout function
 * @param  integer  $priority  Timeout priority
 * @param  integer|null  $exhaust  Exhaustion Rate | Default null
 *
 * @return  array  [signal, handle]
 */
function interval($function, $interval, $instruction = \prggmr\engine\idle\Time::MILLISECONDS, $priority = QUEUE_DEFAULT_PRIORITY, $exhaust = null)
{
    $signal = new Interval($interval, $instruction);
    $handle = \prggmr::instance()->handle($function, $signal, $priority, $exhaust);
    return [$signal, $handle];
}

/**
 * Calls a timeout function after the specified time in microseconds.
 * 
 * @param  object  $function  Closure
 * @param  integer  $timeout  Milliseconds before calling timeout.
 * @param  array  $vars  Variables to pass the timeout function
 * @param  integer  $priority  Timeout priority
 * @param  integer|null  $exhaust  Exhaustion Rate | Default 1
 *
 * @return  array  [signal, handle]
 */
function timeout($function, $timeout, $instruction = \prggmr\engine\idle\Time::MILLISECONDS, $priority = QUEUE_DEFAULT_PRIORITY, $exhaust = 1)
{
    $signal = new Timeout($timeout, $instruction);
    $handle = \prggmr::instance()->handle($function, $signal, $priority, $exhaust);
    return [$signal, $handle];
}


/**
 * Setup a cron based signal.
 *
 * @param  callable  $function  Function to call
 * @param  string  $expression  Cron expression
 * @param  integer  $priority  Priority
 * @param  integer|null  $exhaust  Exhaust rate
 *
 * @return  array  [signal, handle]
 */
function cron($function, $expression, $priority = QUEUE_DEFAULT_PRIORITY, $exhaust = null) {
    $signal = new Cron($expression);
    $handle = \prggmr\handle($function, $signal, $priority, $exhaust);
    return [$signal, $handle];
}
