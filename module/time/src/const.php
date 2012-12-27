<?php
namespace xpspl;

/**
 * Calls a function at the specified intervals of time.
 *
 * @param  integer  $delay  Time between the interval.
 * @param  callable  $callable  Callable variable.
 * @param  array  $instruction  The time instruction. Default = Milliseconds
 *
 * @return  array  [signal, handle]
 */
function interval($delay, $callable, $instruction = \xpspl\engine\idle\Time::MILLISECONDS)
{
    $signal = new \xpspl\time\Interval($delay, $instruction);
    if (!$callable instanceof \xpspl\Handle) {
        $callable = new \xpspl\Handle($callable, null);
    }
    $handle = \xpspl::instance()->handle($signal, $callable);
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
function timeout($delay, $callable, $instruction = \xpspl\engine\idle\Time::MILLISECONDS)
{
    $signal = new \xpspl\time\Timeout($delay, $instruction);
    if (!$callable instanceof \xpspl\Handle) {
        $callable = new \xpspl\Handle($callable, 1);
    }
    $handle = \xpspl::instance()->handle($signal, $callable);
    return [$signal, $handle];
}
