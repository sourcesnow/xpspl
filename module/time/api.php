<?php
namespace prggmr;

/**
 * Calls a function at the specified intervals of time.
 *
 * @param  integer  $delay  Time between the interval.
 * @param  callable  $callable  Callable variable.
 * @param  array  $instruction  The time instruction. Default = Milliseconds
 *
 * @return  array  [signal, handle]
 */
function interval($delay, $callable, $instruction = \prggmr\engine\idle\Time::MILLISECONDS)
{
    $signal = new \prggmr\time\Interval($delay, $instruction);
    if (!$callable instanceof \prggmr\Handle) {
        $callable = new \prggmr\Handle($callable, null);
    }
    $handle = \prggmr::instance()->handle($signal, $callable);
    return [$signal, $handle];
}

/**
 * Calls a function after the specified timeout.
 *
 * @param  integer  $delay  Amount of time to wait.
 * @param  callable  $callable  Callable variable.
 * @param  array  $instruction  The time instruction. Default = Milliseconds
 *
 * @return  array  [signal, handle]
 */
function timeout($delay, $callable, $instruction = \prggmr\engine\idle\Time::MILLISECONDS)
{
    $signal = new \prggmr\time\Timeout($delay, $instruction);
    if (!$callable instanceof \prggmr\Handle) {
        $callable = new \prggmr\Handle($callable, 1);
    }
    $handle = \prggmr::instance()->handle($signal, $callable);
    return [$signal, $handle];
}
