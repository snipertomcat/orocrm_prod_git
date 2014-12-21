<?php

namespace Stc\Bundle\PerformanceBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Stc\Bundle\PerformanceBundle\Entity\Performance;

class PerformanceEvent extends Event
{
    private $performance;

    protected $calendarEvents = [];

    public function __construct(Performance $performance)
    {
        $this->performance = $performance;
    }

    public function getPerformance()
    {
        return $this->performance;
    }

    public function addCalendarEvent($calendarEvent)
    {
        $this->calendarEvents[] = $calendarEvent;
    }

    public function getCalendarEvents()
    {
        return $this->calendarEvents;
    }
}