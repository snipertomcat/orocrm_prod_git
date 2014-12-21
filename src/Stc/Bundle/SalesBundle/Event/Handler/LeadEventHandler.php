<?php

namespace Stc\Bundle\SalesBundle\Event\Handler;


use Doctrine\ORM\EntityManager;
use Oro\Bundle\CalendarBundle\Entity\CalendarEvent;
use Stc\Bundle\SalesBundle\Event\LeadEvent;
use Stc\Core\EventBundle\EventHandler\EventHandlerInterface;
use Symfony\Component\EventDispatcher\Event;


class LeadEventHandler implements EventHandlerInterface
{
    public function handle(Event $event, EntityManager $em)
    {
        $calendarEvents = $event->getCalendarEvents();

        foreach ($calendarEvents as $calendarEvent) {
            //$reminderCheck = $calendarEvent->getReminders();
            $em->persist($calendarEvent);
        }

        $em->flush();
    }

}