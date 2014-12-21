<?php


namespace Stc\Bundle\PerformanceBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Stc\Bundle\PerformanceBundle\Event\Handler\PerformanceEventHandler;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Oro\Bundle\CalendarBundle\Entity\CalendarEvent;
use Stc\Bundle\PerformanceBundle\Entity\Performance;
use Stc\Bundle\PerformanceBundle\Event\PerformanceEvent;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreatePerformanceListener implements ContainerAwareInterface
{

    protected $calendarRepository;

    /** @var PerformanceEventHandler  */
    protected $eventHandler;

    public function __construct(PerformanceEventHandler $eventHandler)
    {
        //$this->calendarRepository = $calendarRepository;
        $this->eventHandler = $eventHandler;
    }

    public function onPerformanceEvent(PerformanceEvent $performanceEvent)
    {
        $this->performanceEvent = $performanceEvent;

        $this->performance = $performanceEvent->getPerformance();

        $this->calendarRepository = $this->container->get('doctrine.orm.entity_manager')->getRepository('OroCalendarBundle:Calendar');

        $this->eventTitle = $this->performance->getName() . "\n" . $this->performance->getVenue() . "\n";
        $bands = $this->performance->getBands();
        $bandString = "";
        foreach ($bands as $band) {
            $bandString .= $band->getName() . ",";
        }
        $this->eventTitle .= $bandString . "\n";

        //$calendar = $this->calendarRepository->findByUser($performance->getOwnerId());

        //print_r($this->performance);print_r($this->performanceEvent);exit;

        /* @todo CHANGE THIS BEFORE GOING LIVE! */
        $ownerCalendar = $this->calendarRepository->findByUser($this->performance->getOwnerId());
        $this->createOwnerCalendarEvent($ownerCalendar);

        $bandCalendar = $this->calendarRepository->findByUser(10);
        $this->createBandCalendarEvent($bandCalendar);

        $venueCalendar = $this->calendarRepository->findByUser(11);
        $this->createVenueCalendarEvent($venueCalendar);

        $performanceCalendar = $this->calendarRepository->findByUser(12);
        $this->createPerformanceCalendarEvent($performanceCalendar);

        $this->eventHandler->handle($this->performanceEvent, $this->container->get('doctrine.orm.entity_manager'));

    }

    private function createOwnerCalendarEvent($calendar)
    {
        $calendarEvent = new CalendarEvent();

        $calendarEvent->setAllDay(1);
        $calendarEvent->setStart($this->performance->getPerformanceDate());
        $calendarEvent->setTitle($this->eventTitle);
        $calendarEvent->setCalendar($calendar);
        $calendarEvent->setEnd($this->performance->getPerformanceDate()->modify('+1 day'));
        //print_r($calendarEvent);exit;
        $this->performanceEvent->addCalendarEvent($calendarEvent);
    }

    private function createBandCalendarEvent($calendar)
    {
        $calendarEvent = new CalendarEvent();

        $calendarEvent->setAllDay(1);
        $calendarEvent->setStart($this->performance->getPerformanceDate());
        $calendarEvent->setTitle($this->eventTitle);
        $calendarEvent->setCalendar($calendar);
        $calendarEvent->setEnd($this->performance->getPerformanceDate()->modify('+1 day'));
        $this->performanceEvent->addCalendarEvent($calendarEvent);
    }

    private function createPerformanceCalendarEvent($calendar)
    {
        $calendarEvent = new CalendarEvent();

        $calendarEvent->setAllDay(1);
        $calendarEvent->setStart($this->performance->getPerformanceDate());
        $calendarEvent->setTitle($this->eventTitle);
        $calendarEvent->setCalendar($calendar);
        $calendarEvent->setEnd($this->performance->getPerformanceDate()->modify('+1 day'));
        $this->performanceEvent->addCalendarEvent($calendarEvent);
    }

    private function createVenueCalendarEvent($calendar)
    {
        $calendarEvent = new CalendarEvent();

        $calendarEvent->setAllDay(1);
        $calendarEvent->setStart($this->performance->getPerformanceDate());
        $calendarEvent->setTitle($this->eventTitle);
        $calendarEvent->setCalendar($calendar);
        $calendarEvent->setEnd($this->performance->getPerformanceDate()->modify('+1 day'));
        $this->performanceEvent->addCalendarEvent($calendarEvent);
    }

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }

    public function setManager(ApiEntityManager $manager)
    {
        $this->manager = $manager;
    }
}

