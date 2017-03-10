<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$loader = require '../vendor/autoload.php';
$loader->addPsr4("Fg\\", dirname(__FILE__).'/../src/');


$aaa = new \Fg\IndexController();
$aaa->index();

new \Fg\Frame\App();


?>