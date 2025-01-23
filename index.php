<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Container;
use App\Controller\HomeController;

(new Container())->get(HomeController::class)->index();
