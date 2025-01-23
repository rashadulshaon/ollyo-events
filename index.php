<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\HomeController;

(new HomeController())->index();
