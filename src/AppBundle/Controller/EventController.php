<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\Ticket;
use AppBundle\Form\Type\CreateEventType;
use AppBundle\Form\Type\CreateTicketType;
use AppBundle\Form\Type\EditEventType;
use AppBundle\Form\Type\LoginEventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    /**
     * @Route("/event/create", name="event_create")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $event = new Event();
        $form = $this->createForm(new CreateEventType(), $event);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event->setPassword(hash('sha512', $event->getPassword()));
            $em->persist($event);
            $em->flush();

            $this->addFlash(
                'success',
                'Succesfully created your event. Bookmark this page to access it later!'
            );

            $session = $request->getSession();
            $session->set($event->getCode(), true);

            return $this->redirectToRoute('event', array('code' => $event->getCode()));
        }
        return $this->render('Event/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/event/{code}", name="event")
     */
    public function eventAction(Request $request, $code) {
        /** @var $event Event */
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')->findOneByCode($code);

        $session = $request->getSession();
        if ($session->get($code)) {
            $em = $this->getDoctrine()->getManager();
            $ticket = new Ticket();

            $ticketForm = $this->createForm(new CreateTicketType(), $ticket);
            $ticketForm->handleRequest($request);
            if ($ticketForm->isValid()) {
                $ticket->setEvent($event);
                $em->persist($ticket);
                $em->flush();
            }

            $eventForm = $this->createForm(new EditEventType(), $event);
            $eventForm->handleRequest($request);
            if ($eventForm->isValid()) {
                $em->persist($event);
                $em->flush();
            }

            $tickets = $this->getDoctrine()->getRepository('AppBundle:Ticket')->findByEvent($event, array('soldTime' => 'DESC'));
            return $this->render('Event/event.html.twig', array('event' => $event, 'ticketForm' => $ticketForm->createView(), 'eventForm' => $eventForm->createView(),'tickets' => $tickets));
        } else {
            $form = $this->createForm(new LoginEventType());

            $form->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();
                if (hash('sha512', $data['password']) == $event->getPassword()) {
                    $session->set($code, true);

                    $this->addFlash(
                        'success',
                        'Succesfully logged in. Welcome back!'
                    );

                    return $this->redirectToRoute('event', array('code' => $event->getCode()));
                } else {
                    $this->addFlash('danger', 'Wrong password. Please try again!');
                }
            }
            return $this->render('Event/login.html.twig', array('form' => $form->createView()));
        }


    }
}


