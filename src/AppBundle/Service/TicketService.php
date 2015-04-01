<?php
/**
 * Created by PhpStorm.
 * User: ramon
 * Date: 01.04.15
 * Time: 20:17
 */

namespace AppBundle\Service;


use AppBundle\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\DependencyInjection\Container;

class TicketService {

    private $doctrine;
    private $em;
    /** @var \Swift_Mailer */
    private $mailer;
    /** @var Container */
    private $container;

    public function __construct($doctrine, $mailer, $container) {
        $this->doctrine = $doctrine;
        $this->em = $doctrine->getEntityManager();
        $this->mailer = $mailer;
        $this->container = $container;
    }

    /**
     * @param $ticket Ticket
     * @param $recipient
     */
    public function sendTicket($ticket, $recipient) {
        $mailer = $this->mailer;
        $message = $mailer->createMessage()
            ->setSubject('Dein '.$ticket->getEvent()->getName().' Ticket')
            ->setFrom($this->container->getParameter('mailer_from'))
            ->setTo($recipient)
            ->setBody(
                $this->container->get('templating')->render(
                // app/Resources/views/Emails/registration.html.twig
                    'Email/ticket.html.twig',
                    array('ticket' => $ticket)
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;
        $mailer->send($message);
    }
}