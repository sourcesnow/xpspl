<?php
/*
Ref. https://github.com/orieg/php-judy/issues/2
*/
$judy = new Judy(Judy::INT_TO_MIXED);
echo "Set INT_TO_MIXED Judy object\n";
$judy[125]  = new DateTime('2012-02-14');
$judy[521]  = new DateTime('1983-07-01');

foreach($judy as $k=>$v)
    print "k: $k, v: ".$v->format('Y')."\n";

unset($judy);
?>
