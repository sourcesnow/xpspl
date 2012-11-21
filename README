## Install

Run the following command and enter your password.

    $ curl -s prggmr.org/prggmr | sh
    $ prggmr -v

__Updates are performed using the same command.__

## Including the library

```php
<?php

require_once 'prggmr/src/prggmr.php';
```

## Options

Options are defined in boolean constants before loading the library.

### PRGGMR_PATH

Path to the library source.

### PRGGMR_EVENT_HISTORY

Remember the event history.

### PRGGMR_DEBUG

Debug mode. ```error_reporting(E_ALL)```

### SIGNAL_ERRORS_EXCEPTIONS

Turn all php errors into a signal.

*Currently this feature has a known problem and does not function*

### WINDOWS

Running windows OS.

*Detected automatically*

## Usage

### Command

prggmr ships with the ```prggmr``` command.

```sh
prggmr -h
usage: prggmr [options...] file

Current options:
  -c/--config   Configuration file
  -d            Used for the development of prggmr.
  -h/--help     Show this help message.
  -p/--passthru Pass the procedding arguments to the file
  -t/--time     Length of time to run in milliseconds.
  -u/--unittest Load the unit testing module.
  -v/--version  Displays current prggmr version.
```

## Examples

### Time based functions

Allow for executing functions based on past time.

```php
<?php
\prggmr\load_module('time');
    
\prggmr\module\time\interval(10, function(){ 
    echo "10 millisecond interval"; 
});

\prggmr\module\time\timeout(50, function(){
    echo "50 second timeout";
}, \prggmr\engine\idle\Time::SECONDS);
```

### Signal and Handle Events

The most basic event procedure.

```php
<?php

prggmr\handle('signal_name', function(){
    echo "The ".\prggmr\current_signal()->get_name()." was trigged";
});

prggmr\signal('signal_name');
```

### Signal Interruption

Direct the flow of an event using functions before and after the signal is trigged.

```php
<?php

prggmr\handle('signal_name', function(){
    echo "The ".\prggmr\current_signal()->get_name()." was trigged";
});

prggmr\before('signal_name', function(){
    echo "Called before ".\prggmr\current_signal()->get_name()." was trigged";
});

prggmr\after('signal_name', function(){
    echo "Called after ".\prggmr\current_signal()->get_name()." was trigged";
});

prggmr\signal('signal_name');
```

### Aynchronous TCP Connection

```php
<?php
    
prggmr\load_signal('socket');

$server = new prggmr\signal\socket\Server("0.0.0.0:1337");

// On Connect
$server->on_connect(function(){
    echo "New Connection".PHP_EOL;
    $this->write("Hello".PHP_EOL);
});

// On Disconnect
$server->on_disconnect(function(){
    echo "Disconnecting".PHP_EOL;
    $this->write("Goodbye".PHP_EOL);
});

// Register the server
prggmr\handle(function(){
    echo "Server is running at ".$this->get_address().PHP_EOL;
}, $server);

## Support

### Mailing list

[Google Group](https://groups.google.com/forum/?fromgroups#!forum/prggmr).


### IRC

```#prggmr``` on ```irc.freenode.net```.

*I am usually idle in the channel when available.*

## Versioning

prggmr uses [semver](http://semver.org).
