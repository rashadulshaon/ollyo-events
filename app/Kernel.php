<?php

namespace App;

use App\Controller\HomeController;

class Kernel
{
    private $excludeAutowires = [
        'App\\Model',
    ];

    public function __construct()
    {
        $container = new Container($this->excludeAutowires);
        $homeController = $container->get(HomeController::class);
        $homeController->index();
    }
}
