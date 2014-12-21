<?php

namespace Stc\Bundle\GoogleMapBundle\Controller\Api\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Stc\Bundle\GoogleMapBundle\Entity\GoogleMap;

/**
 * Class GoogleMapController
 *
 * @package Stc\Bundle\GoogleMapBundle\Controller\
 * @Route("/googlemap")
 */
class GoogleMapController extends Controller
{
    /**
     * @Template
     * @Route("/", name="stc_googlemap_index")
     * @return array
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Template("StcGoogleMapBundle:GoogleMap:update.html.twig")
     * @Route("/create", name="stc_googlemap_create")
     */
    public function createAction()
    {
        return $this->update(new GoogleMap());
    }

    /**
     * @Template
     * @Route("/update/{id}", name="stc_googlemap_update", requirements={"id"="\d+"}, defaults={"id"=0})
     */
    public function updateAction(GoogleMap $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param GoogleMap $entity
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(GoogleMap $entity)
    {

    }
}
