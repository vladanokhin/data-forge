<?php

use Src\App;

require_once '../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable('../');

$dotenv->load();

$app = new App();

$app->run();
