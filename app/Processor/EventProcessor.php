<?php

namespace App\Processor;

use App\Attributes\Route;

class EventProcessor
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
