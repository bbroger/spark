<?php

require __DIR__ . '/../vendor/autoload.php';

$a = [
    'teste.test' => 'ok',
    'eae' => 'blz'
];

foreach ($a as $k => $v) {
    dump(data_set($a, $k, $v));
}

dump('---FINAL---');
dump($a);