<?php

namespace Stc\Bundle\GoogleMapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Stc\Bundle\GoogleMapBundle\Entity\GoogleMap;
use Symfony\Component\HttpFoundation\Response;

use Ivory\GoogleMap\Helper\MapHelper;

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
     * @Route("/map/display", name="stc_googlemaps_map")
     *
     * @Template
     * @AclAncestor("orocrm_contact_view")
     */
    public function mapAction($map)
    {
        return array(
            'map' => $map
        );
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
     * @Route("/view/{id}", name="stc_googlemap_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("stc_googlemap_index")
     */
    public function viewAction(GoogleMap $map)
    {
        $mapType = $map->getMapType();

        $dataBuilderService = 'stc.googlemap.data_builder.'.strtolower($mapType);

        $dataBuilder = $this->get($dataBuilderService);

        $mapObject = $dataBuilder->build();

        $finishedMap = $mapObject;

        //print_r($mapObject);exit;

        $mapHelper = new MapHelper();

        $mapHtml = $mapHelper->render($finishedMap);

        //print_r($mapObject);exit;
        //echo $mapHtml;

        echo "<script>jQuery(window).load(function(){
            initialize();
            google.maps.event.trigger(map, 'resize');
        });</script>";

        return $this->render(
            'StcGoogleMapBundle:GoogleMap:map.html.twig',
            [
                'map' => $mapHtml,
                'entity' => $map
            ]
        );

        //return array('entity' => $map);
    }

    /**
     * @param GoogleMap $entity
     */
    protected function update(GoogleMap $entity)
    {
    /*        if ($this->get('stc.form.handler.googlemap')->process($entity)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('stc.controller.googlemap.saved.message')
            );

            return $this->get('oro_ui.router')->actionRedirect(
                array(
                    'route'      => 'stc_googlemap_update',
                    'parameters' => array('id' => $entity->getId()),
                ),
                array(
                    'route' => 'stc_googlemap_index',
                )
            );
        }

        return [
            'form' => $this->get('stc.form.googlemap')->createView()
        ];
    */

        return $this->viewAction($entity);
    }
}
