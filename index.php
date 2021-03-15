<?php

use App\controller\WebArchController;
use Slim\Factory\AppFactory;


require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/',WebArchController::class . ':index');

$app->post('/', WebArchController::class . ':form');

$app->run();