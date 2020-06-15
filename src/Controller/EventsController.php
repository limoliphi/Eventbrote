<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/events/create", name="events_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $event = new Event();

        $form = $this->createFormBuilder($event)
            ->add('name', TextType::class)
            ->add('location', TextType::class)
            ->add('price', NumberType::class, ['html5' => true, 'scale' => 2])
            ->add('description', TextareaType::class, ['attr' => ['rows' => 5]])
            ->add('startAt', DateTimeType::class, ['label' => 'Starts at'])
            ->getForm();

        $form->handleRequest(($request));

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('events_show', ['id' => $event->getId()]);

        }

        return $this->render('events/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/events/{id}", name="events_show", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function show(Event $event)
    {

        return $this->render('events/show.html.twig', compact('event'));
    }

    /**
     * @Route("/events/{id}/edit", name="events_edit", requirements={"id": "\d+"}, methods={"GET", "PATCH"})
     */
    public function edit(Request $request, Event $event, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder($event, ['method' => 'PATCH'])
            ->add('name', TextType::class)
            ->add('location', TextType::class)
            ->add('price', NumberType::class, ['html5' => true, 'scale' => 2])
            ->add('description', TextareaType::class, ['attr' => ['rows' => 5]])
            ->add('startAt', DateTimeType::class, ['label' => 'Starts at'])
            ->getForm();

        $form->handleRequest(($request));

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('events_show', ['id' => $event->getId()]);

        }

        return $this->render('events/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView()
        ]);
    }
}