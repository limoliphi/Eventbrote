<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/events", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {

        $events = $eventRepository->findAll();

        return $this->render('events/index.html.twig', compact('events'));

    }

    /**
     * @Route("/events/{id}", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function show(int $id, EventRepository $eventRepository)
    {
        $event = $eventRepository->find($id);

        return $this->render('events/show.html.twig', compact('event'));
    }
}