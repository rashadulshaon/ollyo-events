<?php

namespace App\Service;

class GreetService
{
    public function __construct(private WelcomeService $welcomeService) {}
    public function sayHello()
    {
        $this->welcomeService->sayWelcome();
    }
}
