<?php

namespace Stc\Bundle\SalesBundle\Tests\unit\EventListener;

use PHPUnit_Framework_TestCase;
use Stc\Bundle\SalesBundle\Event\LeadEvent;
use Stc\Bundle\SalesBundle\Event\LeadEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

class CreateLeadEventListenerTest extends PHPUnit_Framework_TestCase
{
    public function testEventFired()
    {

/*        $eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        $lead = $this->getMock('OroCRM\Bundle\SalesBundle\Entity\Lead');

        $event = $this->getMock(
            'Stc\Bundle\SalesBundle\Event\LeadEvent',
            [],
            [
                $lead
            ]
        );

        $result = $eventDispatcher->dispatch(
            LeadEvents::NEW_LEAD_CREATED,
            new LeadEvent($lead)
        );

        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');*/


    }
}