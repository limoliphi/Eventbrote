<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     * @Route("/events", name="events_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {

        $events = $eventRepository->findAll();

        return $this->render('events/index.html.twig', compact('events'));

    }

    /**
     * @Route("/events/{id}", name="events_show", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function show(EventRepository $eventRepository, Event $event)
    {

        return $this->render('events/show.html.twig', compact('event'));
    }
}