<?php
/**
 * Stream socket accept does not accept floats as documented
 */
function milliseconds(/* ... */) {
    return round(microtime(true) * 1000);
}
$socket = stream_socket_server('tcp://127.0.0.1:5000', $errno, $errstr);
stream_set_blocking($socket, 0);
echo "START TIME".PHP_EOL;
echo milliseconds().PHP_EOL;
while(false !== $connect = @stream_socket_accept($socket, .0010)) {
}
echo "END TIME".PHP_EOL;
echo milliseconds().PHP_EOL;
echo "START TIME".PHP_EOL;
echo milliseconds().PHP_EOL;
usleep(10 * 1000);
echo "END TIME".PHP_EOL;
echo milliseconds().PHP_EOL;