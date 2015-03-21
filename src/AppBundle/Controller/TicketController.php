<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\Ticket;
use AppBundle\Form\Type\CheckinType;
use AppBundle\Form\Type\CheckoutType;
use AppBundle\Form\Type\CreateEventType;
use AppBundle\Form\Type\CreateTicketType;
use AppBundle\Form\Type\LoginEventType;
use AppBundle\Form\Type\PayTicketType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TicketController extends Controller
{
    /**
     * @Route("/event/{code}/ticket/{ticket}", name="ticket")
     */
    public function ticketAction(Request $request, $code, $ticket) {
        /** @var $ticket Ticket */
        $ticket = $this->getDoctrine()->getRepository('AppBundle:Ticket')->findOneByCode($ticket);
        /** @var $event Event */
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')->findOneByCode($code);

        $em = $this->getDoctrine()->getEntityManager();

        $session = $request->getSession();
        if ($session->get($code)) {
            $checkinForm = $this->createForm(new CheckinType());
            $checkinForm->handleRequest($request);
            if ($checkinForm->isValid()) {
                $ticket->setCheckedIn(true);
                $em->persist($ticket);
                $em->flush();
                $this->addFlash(
                    'success',
                    'Successfully checked in!'
                );
            }
            $checkoutForm = $this->createForm(new CheckoutType());
            $checkoutForm->handleRequest($request);
            if ($checkoutForm->isValid()) {
                $ticket->setCheckedIn(false);
                $em->persist($ticket);
                $em->flush();
                $this->addFlash(
                    'success',
                    'Successfully checked out!'
                );
            }
            $paidForm = $this->createForm(new PayTicketType());
            $paidForm->handleRequest($request);
            if ($paidForm->isValid()) {
                $ticket->setPaid(true);
                $em->persist($ticket);
                $em->flush();
                $this->addFlash(
                    'success',
                    'Successfully set ticket to paid!'
                );
            }
            return $this->render('Ticket/ticket.html.twig', array('ticket' => $ticket,
                'checkinForm' => $checkinForm->createView(), 'checkoutForm' => $checkoutForm->createView(),
                'paidForm' => $paidForm->createView()));
        } else {
            $this->addFlash(
                'alert',
                'You are not allowed to see this tickets data. Please login first!'
            );
            return $this->redirectToRoute('event', array('code' => $event->getCode()));
        }

    }
}


