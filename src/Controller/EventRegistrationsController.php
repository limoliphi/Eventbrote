<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Form\EventRegistrationFormType;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventRegistrationsController extends AbstractController
{
    /**
     * @Route("/events/{event}/registrations", name="events_registrations_index", methods={"GET"})
     */
    public function index(Event $event)
    {

        return $this->render('registrations/index.html.twig', [
            'event' => $event,
            'registrations' => $event->getRegistrations(),
        ]);
    }

    /**
     * @Route("/events/{event}/registrations/create", name="events_registrations_create", methods={"GET", "POST"})
     */
    public function create(Event $event, Request $request, EntityManagerInterface $em)
    {

        $registration = new Registration();

        $form = $this->createForm(EventRegistrationFormType::class, $registration);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registration->setEvent($event);

            $em->persist($registration);
            $em->flush();

            $this->addFlash('success', 'Thanks, you\'re registered !');

            return $this->redirectToRoute('events_registrations_index', ['event' => $event->getId()]);

        }

        return $this->render('registrations/create.html.twig', [
            'event' => $event,
            'form' => $form->createView()
        ]);
    }
}
