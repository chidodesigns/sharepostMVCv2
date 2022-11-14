<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__).'/.env');

require dirname(__DIR__).'/config/routes/routes.php';
require dirname(__DIR__).'/config/database.php';
