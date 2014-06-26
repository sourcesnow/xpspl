# XPSPL

[![Code Climate](https://codeclimate.com/github/prggmr/xpspl.png)](https://codeclimate.com/github/prggmr/xpspl) [![Total Downloads](https://poser.pugx.org/prggmr/xpspl/downloads.svg)](https://packagist.org/packages/prggmr/xpspl) [![Latest Stable Version](https://poser.pugx.org/prggmr/xpspl/v/stable.svg)](https://packagist.org/packages/prggmr/xpspl)

PHP Signal and Event Library.

XPSPL is a high-performance event loop that supports the following event types,

* Signals
* Timers
* I/O (Asynchronous)
* Complex Signals
* Idle

The best way to think of XPSPL is as a libevent and libev library only written in PHP and much less mature.

## I/O Poll Support

Currently the only supported polling mechnanism is `select`.

## Install

XPSPL is installed using composer.

```
{
  'require': {
    'prggmr\xpspl': 'v5.0.0'
  }
}
```

## Documentation

XPSPL's documentation is available at http://xpspl.readthedocs.org.

## Threads

Threads are currently being experimented with using the `pthreads` PHP extension.
