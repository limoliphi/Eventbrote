<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationsController extends AbstractController
{
    /**
     * @Route("/events/{event}/registrations", name="registrations_index")
     */
    public function index(Event $event)
    {

        return $this->render('registrations/index.html.twig', [
            'event' => $event,
            'registrations' => $event->getRegistrations(),
        ]);
    }
}
