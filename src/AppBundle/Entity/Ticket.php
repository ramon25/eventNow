<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Ticket
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TicketRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ticket
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name_on_ticket", type="string", length=255, nullable=true)
     */
    private $nameOnTicket;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="sold_time", type="datetime")
     */
    private $soldTime;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var boolean
     *
     * @ORM\Column(name="checked_in", type="boolean")
     */
    private $checkedIn = false;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="tickets")
     */
    private $event;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Ticket
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set checkedIn
     *
     * @param boolean $checkedIn
     * @return Ticket
     */
    public function setCheckedIn($checkedIn)
    {
        $this->checkedIn = $checkedIn;

        return $this;
    }

    /**
     * Get checkedIn
     *
     * @return boolean 
     */
    public function getCheckedIn()
    {
        return $this->checkedIn;
    }

    /**
     * Set event
     *
     * @param \AppBundle\Entity\Event $event
     * @return Ticket
     */
    public function setEvent(\AppBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \AppBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @ORM\PrePersist
     */
    public function createCode()
    {
        $generator = new SecureRandom();
        $random = bin2hex($generator->nextBytes(10));
        $this->code = $random;
    }

    /**
     * @ORM\PrePersist
     */
    public function setTimestamp()
    {
        $time = new DateTime();
        $time->setTimestamp(time());
        $this->soldTime = $time;
    }

    /**
     * Set nameOnTicket
     *
     * @param string $nameOnTicket
     * @return Ticket
     */
    public function setNameOnTicket($nameOnTicket)
    {
        $this->nameOnTicket = $nameOnTicket;

        return $this;
    }

    /**
     * Get nameOnTicket
     *
     * @return string 
     */
    public function getNameOnTicket()
    {
        return $this->nameOnTicket;
    }

    /**
     * Set soldTime
     *
     * @param \DateTime $soldTime
     * @return Ticket
     */
    public function setSoldTime($soldTime)
    {
        $this->soldTime = $soldTime;

        return $this;
    }

    /**
     * Get soldTime
     *
     * @return \DateTime 
     */
    public function getSoldTime()
    {
        return $this->soldTime;
    }
}
