<?php

namespace Stc\Bundle\PerformanceBundle\Event\Handler;

use Stc\Bundle\PerformanceBundle\Event\Handler\PerformanceEventHandlerInterface;
use Stc\Bundle\PerformanceBundle\Event\PerformanceEvent;
use Doctrine\ORM\EntityManager;


class PerformanceEventHandler implements PerformanceEventHandlerInterface
{

    public function handle(PerformanceEvent $event, $em)
    {
        $calendarEvents = $event->getCalendarEvents();

        foreach ($calendarEvents as $calendarEvent) {
            $em->persist($calendarEvent);
        }

        $em->flush();
    }
}