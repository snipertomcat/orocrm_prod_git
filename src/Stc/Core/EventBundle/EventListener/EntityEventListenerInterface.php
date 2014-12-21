<?php

namespace Stc\Core\EventBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

use Stc\Core\EventBundle\EventHandler\EventHandlerInterface;

interface EntityEventListenerInterface extends ContainerAwareInterface
{
    public function __construct(EventHandlerInterface $eventHandler);
    public function onCreateEvent(Event $event);
    public function setContainer(ContainerInterface $container=null);
}
