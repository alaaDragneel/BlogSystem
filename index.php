<?php

require __DIR__ . '/vendor/System/Application.php';
require __DIR__ . '/vendor/System/File.php';

use System\Application;
use System\File;

$file = new File(__DIR__);

$app = new Application($file);


$a = [
    'ak1' => 'av1',
    'ak2' => 'av2',
    'ak3' => 'av3',
    'ak4' => 'av4',
    'ak5' => 'av5',
];

$b = [
    'bk1' => 'bv1',
    'bk2' => 'bv2',
    'bk3' => 'bv3',
    'bk4' => 'bv4',
    'bk5' => 'bv5',
];

$object = $app;

$c = [
    'a' => &$a,
    'b' => $b,
    $object
];

dd($c, $file);
