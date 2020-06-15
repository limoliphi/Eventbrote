<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
    public function show(Event $event)
    {

        return $this->render('events/show.html.twig', compact('event'));
    }

    /**
     * @Route("/events/{id}/edit", name="events_edit", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function edit(Event $event)
    {
        $form = $this->createFormBuilder($event)
            ->add('name', TextType::class)
            ->add('location', TextType::class)
            ->add('price', NumberType::class, ['html5' => true, 'scale' => 2])
            ->add('description', TextareaType::class, ['attr' => ['rows' => 5]])
            ->add('startAt', DateTimeType::class)
            ->getForm();

        return $this->render('events/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView()
        ]);
    }
}