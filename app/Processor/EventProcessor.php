<?php

namespace App\Processor;

use App\Attributes\Route;
use App\Blueprint\Event;
use App\Container;
use App\Database\SchemaHandler;

class EventProcessor
{
    private $container;
    private $db;
    private $eventBlueprint;
    private $baseTemplateDir = __DIR__ . '/../../templates/';

    public function __construct()
    {
        $this->container = new Container();
        $this->db = $this->container->get(SchemaHandler::class);
        $this->eventBlueprint = $this->container->get(Event::class);
    }

    #[Route(path: '/', method: 'GET')]
    public function index()
    {
        $this->db->updateSchema();
        $data = $this->eventBlueprint->readMultiple(itemsPerPage: 8, pageNumber: 1);

        return require_once $this->baseTemplateDir . 'homepage.php';
    }

    #[Route(path: '/events/{eventId}', method: 'GET')]
    public function event(int $eventId)
    {
        return "Showing event with ID: " . $eventId;
    }
}
