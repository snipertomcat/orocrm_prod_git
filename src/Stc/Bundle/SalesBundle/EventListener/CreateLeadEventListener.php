<?php


namespace Stc\Bundle\SalesBundle\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Oro\Bundle\CalendarBundle\Entity\CalendarEvent;
use Symfony\Component\EventDispatcher\Event;
use Doctrine\ORM\EntityManager;
use Oro\Bundle\ReminderBundle\Entity\Reminder;
use Oro\Bundle\ReminderBundle\Model\ReminderInterval;
use Stc\Core\EventBundle\EventHandler\EventHandlerInterface;
use Stc\Core\EventBundle\EventListener\EntityEventListenerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateLeadEventListener implements EntityEventListenerInterface
{
    /** @var \Stc\Core\EventBundle\EventHandler\EventHandlerInterface  */
    protected $eventHandler;

    protected $calendarRepository;

    public function __construct(EventHandlerInterface $eventHandler)
    {
        $this->eventHandler = $eventHandler;
    }

    public function onCreateEvent(Event $lead)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->container->getDoctrine->getManager();

        $this->leadEvent = $lead;
        $this->lead = $this->leadEvent->getLead();

        //fetch users calendar
        $this->calendarRepository = $this->container->get('doctrine.orm.entity_manager')->getRepository('OroCalendarBundle:Calendar');
        $ownerCalendar = $this->calendarRepository->findByUser($this->lead->getOwnerId());

        //create reminder:
        $reminderDate = $this->lead->getReminder();
        $reminder = new Reminder();
        $reminder->setCreatedAt(new \DateTime('now'))
            ->setExpireAt($reminderDate->createFromFormat('+1 day'))
            ->setMethod('web_socket')
            ->setRecipient($this->lead->getOwner())
            ->setInterval(new ReminderInterval(1, 'D'))
            ->setRelatedEntityClassName('Oro\Bundle\CalendarBundle\Entity\CalendarEvent')
            //->setRelatedEntityId($this->lead->getId())
            ->setState('not_sent')
            ->setSubject($this->lead->getName());

        //create calendar event & attach the reminder object:
        $this->createOwnerCalendarEvent($ownerCalendar, $reminder);

        //call the handler to persist the objects:
        $this->eventHandler->handle($this->leadEvent, $entityManager);

    }

    private function createOwnerCalendarEvent($calendar, $reminder)
    {
        //create string of band names:
        $eventTitle = $this->lead->getName() . "\n" . $this->lead->getVenue() . "\n";
        $bands = $this->lead->getBands();
        $bandString = "";
        foreach ($bands as $band) {
            $bandString .= $band->getName() . ",";
        }
        $eventTitle .= $bandString . "\n";

        $calendarEvent = new CalendarEvent();

        $calendarEvent->setAllDay(1);
        $calendarEvent->setStart($this->lead->getPerformanceDate());
        $calendarEvent->setTitle($eventTitle);
        $calendarEvent->setCalendar($calendar);
        $calendarEvent->setEnd($this->lead->getPerformanceDate()->modify('+1 day'));
        $calendarEvent->setReminders(new ArrayCollection($reminder));

        //set the calendar event w/the attached reminder back the LeadEvent object:
        $this->leadEvent->addCalendarEvent($calendarEvent);
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}