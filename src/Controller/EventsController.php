<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/events")
     */
    public function index()
    {
        $events  = ['Symfony Conference', 'Laravel Conference', 'PHP Conference'];
        return $this->render('events/index.html.twig', compact('events'));

    }
}