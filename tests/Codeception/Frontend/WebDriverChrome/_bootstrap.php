<?php
// This is global bootstrap for autoloading

$path = dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR . 'bootstrap.php';
include_once $path;
