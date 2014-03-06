<?php
xp_import('time');
xp_import('ftp');

// Must provide username/password
$connection = [
    'hostname' => 'ftps://app.brickftp.com',
    'username' => '-',
    'password' => '-',
    'secure'   => false
];

$files = [
    dirname(realpath(__FILE__)).'/file_1.txt',
    dirname(realpath(__FILE__)).'/file_2.txt',
    dirname(realpath(__FILE__)).'/file_3.txt',
    dirname(realpath(__FILE__)).'/file_4.txt'
];

$uploader = ftp\upload($files, $connection, function($signal){
    echo "Upload Started".PHP_EOL;
});

ftp\complete($uploader, function($signal){
    echo $signal->get_file()->get_name() . ' uploaded succesfully'.PHP_EOL;
});

ftp\failure($uploader, function($signal){
    echo $signal->get_file()->get_name() . ' failed to upload'.PHP_EOL;
});