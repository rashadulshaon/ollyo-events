<?php

namespace App\Processor;

use App\Attributes\Route;
use App\Blueprint\Event;
use App\Blueprint\Registration;
use App\Container;
use App\Database\SchemaHandler;

class EventProcessor
{
    private $container;
    private $db;
    private $eventBlueprint;
    private $registrationBlueprint;
    private $baseTemplateDir = __DIR__ . '/../../templates/';

    public function __construct()
    {
        $this->container = new Container();
        $this->db = $this->container->get(SchemaHandler::class);
        $this->eventBlueprint = $this->container->get(Event::class);
        $this->registrationBlueprint = $this->container->get(Registration::class);
    }

    #[Route(path: '/', method: 'GET')]
    public function index()
    {
        $this->db->updateSchema();
        $data = $this->eventBlueprint->readMultiple(itemsPerPage: 8, pageNumber: 1);

        require_once $this->baseTemplateDir . 'homepage.php';
    }

    #[Route(path: '/create', method: 'GET')]
    public function create()
    {
        require_once $this->baseTemplateDir . 'event_create.php';
    }

    #[Route(path: '/create', method: 'POST')]
    public function processCreate()
    {
        $this->eventBlueprint->create([
            'title' => $_POST['title'],
            'summary' => $_POST['summary'],
            'image_url' => $_POST['image_url'],
            'phone' => $_POST['phone'],
            'max_participants' => $_POST['max_participants'],
        ]);

        $actionSuccess = true;
        $actionMessage = 'Event created successfully';
        require_once $this->baseTemplateDir . 'action_result.php';
    }

    #[Route(path: '/book/{eventId}', method: 'GET')]
    public function book(int $eventId)
    {
        $event = $this->eventBlueprint->read($eventId);
        require_once $this->baseTemplateDir . 'event_registration.php';
    }

    #[Route(path: '/book/{eventId}', method: 'POST')]
    public function processBooking(int $eventId)
    {
        $registration = $this->registrationBlueprint->create([
            'event_id' => $eventId,
            'name' => $_POST['name'],
            'age' => $_POST['age'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'occupation' => $_POST['occupation'],
            'shirt_size' => $_POST['shirt_size'],
            'address' => $_POST['address'],
        ]);

        $actionSuccess = $registration ? true : false;
        $actionMessage = $registration ? 'Your registration was successful!' : 'Registration failed';
        require_once $this->baseTemplateDir . 'action_result.php';
    }
}
