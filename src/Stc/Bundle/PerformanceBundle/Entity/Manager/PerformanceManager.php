<?php

namespace Stc\Bundle\PerformanceBundle\Entity\Manager;

use Stc\Bundle\PerformanceBundle\Event\PerformanceEvent;
use Stc\Bundle\PerformanceBundle\Event\PerformanceEvents;
use Stc\Bundle\PerformanceBundle\EventListener\CreatePerformanceListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use Stc\Bundle\PerformanceBundle\Entity\Performance;

/**
 * Class PerformanceManager
 * @package Stc\Bundle\PerformanceBundle\Manager
 *
 * This class handles the dispatching of the 'stc_performance.new_performance_created' event
 * The only other functionality that should be added to this class are that which deal
 * with directly interacting to the persistence layer.
 */
class PerformanceManager
{
    private $eventDispatcher;

    private $entityManager;

    public function __construct(EventDispatcherInterface $eventDispatcher, EntityManager $entityManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->entityManager = $entityManager;
    }

    public function createPerformance(Performance $performance)
    {

        $this->entityManager->persist($performance);

        $this->entityManager->flush();

        $event = new PerformanceEvent($performance);

        $listener = new CreatePerformanceListener();

        $this->eventDispatcher->addListener('stc_performance.new_performance_created', array($listener, 'onPerformanceEvent'));

        $this->eventDispatcher->dispatch(PerformanceEvents::NEW_PERFORMANCE_CREATED, $event);

    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }


}