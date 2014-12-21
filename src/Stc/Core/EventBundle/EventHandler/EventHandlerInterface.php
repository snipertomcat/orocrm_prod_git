<?php

namespace Stc\Core\EventBundle\EventHandler;

use Symfony\Component\EventDispatcher\Event;
use Doctrine\ORM\EntityManager;

interface EventHandlerInterface
{
    public function handle(Event $event, EntityManager $em);
}