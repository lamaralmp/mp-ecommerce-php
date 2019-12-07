<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$json = file_get_contents("php://input");
$json = json_decode($json);

$name = 'arquivo.txt';
$text = var_export($json, true) . PHP_EOL . PHP_EOL;

;
$file = fopen($name, 'a');
fwrite($file, $text);
fclose($file);