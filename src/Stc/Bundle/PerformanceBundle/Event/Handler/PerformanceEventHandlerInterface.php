<?php

namespace Stc\Bundle\PerformanceBundle\Event\Handler;

use Stc\Bundle\PerformanceBundle\Entity\Performance;
use Stc\Bundle\PerformanceBundle\Event\PerformanceEvent;
use Oro\Bundle\CalendarBundle\Entity\Calendar;

interface PerformanceEventHandlerInterface
{
    /**
     * Handle event
     *
     * @param PerformanceEvent $event
     * @param Calendar[] $calendarEvents
     * @return mixed
     */
    public function handle(PerformanceEvent $event, $em);
}
