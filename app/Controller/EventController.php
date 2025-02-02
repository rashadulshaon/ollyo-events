<?php

namespace App\Controller;

use App\Attributes\Route;

class EventController
{
    #[Route(path: '/', method: 'GET')]
    public function index()
    {
        return "Welcome to Ollyo Events!";
    }

    #[Route(path: '/events/{eventId}', method: 'GET')]
    public function event(int $eventId)
    {
        return "Showing event with ID: " . $eventId;
    }
}
