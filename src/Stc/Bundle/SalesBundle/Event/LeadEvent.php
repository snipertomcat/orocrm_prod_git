<?php

namespace Stc\Bundle\SalesBundle\Event;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Event;
use OroCRM\Bundle\SalesBundle\Entity\Lead;

class LeadEvent extends Event
{
    private $lead;

    protected $calendarEvents = [];

    protected $reminders = [];

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function getLead()
    {
        return $this->lead;
    }

    public function addCalendarEvent($calendarEvent)
    {
        $this->calendarEvents[] = $calendarEvent;
    }

    public function getCalendarEvents()
    {
        return $this->calendarEvents;
    }

    public function addReminder($reminder)
    {
        $this->reminders[] = $reminder;
    }

    public function getReminder()
    {
        return $this->reminders;
    }
}