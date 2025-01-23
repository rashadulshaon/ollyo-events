<?php

namespace App\Controller;

use App\Service\GreetService;

class HomeController
{
    public function __construct(
        private GreetService $greetService,
    ) {}

    public function index()
    {
        $this->greetService->sayHello();
    }
}
