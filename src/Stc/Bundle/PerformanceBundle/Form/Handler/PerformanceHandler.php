<?php

namespace Stc\Bundle\PerformanceBundle\Form\Handler;

use Doctrine\ORM\EntityManager;

use Stc\Bundle\PerformanceBundle\Event\PerformanceEvent;
use Stc\Bundle\PerformanceBundle\Event\PerformanceEvents;
use Stc\Bundle\PerformanceBundle\EventListener\CreatePerformanceListener;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use Oro\Bundle\TagBundle\Entity\TagManager;

use Stc\Bundle\PerformanceBundle\Entity\Performance;
use Stc\Bundle\BandBundle\Entity\Band;
use Stc\Bundle\VenueBundle\Entity\Venue;
use Symfony\Component\EventDispatcher\EventDispatcher;

class PerformanceHandler
{
    /** @var FormInterface */
    protected $form;

    /** @var Request */
    protected $request;

    /** @var EntityManager */
    protected $manager;

    /** @var TagManager */
    protected $tagManager;

    /** @var EventDispatcher */
    protected $eventDispatcher;

    /**
     * @param FormInterface $form
     * @param Request       $request
     * @param EntityManager $manager
     */
    public function __construct(FormInterface $form, Request $request, EntityManager $manager, TagManager $tagManager, EventDispatcher $eventDispatcher)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->manager = $manager;
        $this->tagManager = $tagManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Process form
     *
     * @param  Performance $entity
     *
     * @return bool  True on successful processing, false otherwise
     */
    public function handle(Performance $entity)
    {
        //var_dump($entity);exit;
        //set a default tag:
        $entity->setTags('performance');

        //set required value for estimated attendance:
		$estimatedAttendance = $entity->getEstimatedAttendance();
        if ($estimatedAttendance == null) {
            $entity->setEstimatedAttendance(0);
        }

        //set empty sales stage to default of 'prospecting'
		$salesStage = $entity->getSalesStage();
        if ($salesStage == null) {
            $entity->setSalesStage('prospecting');
        }

        //set default for meals included:
		$mealsIncluded = $entity->isMealsIncluded();
        if ($mealsIncluded == null) {
            $entity->setMealsIncluded(0);
        }

        //set other default field values:
        $entity->setDeleted(0);
        $entity->setStatus(1);

        //increase each band's performance count (rating) by 1

        $bands = $entity->getBands();
        //var_dump($bands);
        //echo "<pre>".var_dump($_POST);
        //exit;
        /*foreach ($bands as $band) {
            $band->addPerformanceCount();
        }*/

        $this->form->setData($entity);
        $this->form->submit($this->request);


        $this->onSuccess($entity);
        return true;

        if ($this->form->isValid()) {


        } else {
            exit;
        }

        //return false;
    }

    /**
     * "Success" form handler
     *
     * @param Performance $entity
     */
    protected function onSuccess(Performance $entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();

        $this->tagManager->saveTagging($entity);

    }

    /**
     * {@inheritdoc}
     */
    public function setTagManager(TagManager $tagManager)
    {
        $this->tagManager = $tagManager;
    }

}