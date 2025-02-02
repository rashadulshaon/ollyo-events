<?php

namespace App\Processor;

use App\Attributes\Route;
use App\Blueprint\Event;
use App\Container;
use App\ORM\DBHandler;

class EventProcessor
{
    private $container;
    private $db;
    private $event;

    public function __construct()
    {
        $this->container = new Container();
        $this->db = $this->container->get(DBHandler::class);
        $this->event = $this->container->get(Event::class);
    }

    #[Route(path: '/', method: 'GET')]
    public function index()
    {
        $this->db->updateSchema();
        $eventInstance = $this->event->create([
            'title' => 'Test Event',
            'description' => 'This is a test event.'
        ]);

        dump_and_die($eventInstance);

        return "Welcome to Ollyo Events!";
    }

    #[Route(path: '/events/{eventId}', method: 'GET')]
    public function event(int $eventId)
    {
        return "Showing event with ID: " . $eventId;
    }
}
