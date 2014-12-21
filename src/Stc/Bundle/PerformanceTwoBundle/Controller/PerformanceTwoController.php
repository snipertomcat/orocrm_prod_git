<?php

namespace Stc\Bundle\PerformanceTwoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Oro\Bundle\UserBundle\Entity\User;
use Stc\Bundle\PerformanceTwoBundle\Entity\PerformanceTwo;

use Stc\Bundle\PerformanceTwoBundle\Form\Type\PerformanceTwoType;


/**
 * @Route("/performancetwo")
 */
class PerformanceTwoController extends Controller
{
    /**
     * @Route(
     * ".{_format}",
     * name="stc_performancetwo_index",
     * requirements={"_format"="html|json"},
     * defaults={"_format" = "html"}
     * )
     * @Template
     * @Acl(
     * id="stc_performancetwo_index",
     * type="entity",
     * class="StcPerformanceTwoBundle:PerformanceTwo",
     * permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/view/{id}", name="stc_performancetwo_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_performancetwo_view",
     * type="entity",
     * class="StcPerformanceTwoBundle:PerformanceTwo",
     * permission="VIEW"
     * )
     */
    public function viewAction(PerformanceTwo $performancetwo)
    {
        return array('entity' => $performancetwo);
    }


    /**
     * @Route("/create", name="stc_performancetwo_create")
     * @Template("StcPerformanceTwoBundle:PerformanceTwo:update.html.twig")
     * @Acl(
     * id="stc_performancetwo_create",
     * type="entity",
     * class="StcPerformanceTwoBundle:PerformanceTwo",
     * permission="CREATE"
     * )
     */
    public function createAction()
    {
        $performancetwo = new PerformanceTwo();

        $token = $this->get('security.context')->getToken();
        //$username = $context->getUsername();
        $user = $token->getUser();

        $performancetwo->setCreatedAt(new \DateTime('now'));
        $performancetwo->setStatus(1);
        $performancetwo->setDeleted(0);
        $performancetwo->setAssignee($user);
        $performancetwo->setOwner($user);

        return $this->update($performancetwo);
    }

    /**
     * @Route("/update/{id}", name="stc_performancetwo_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_performancetwo_update",
     * type="entity",
     * class="StcPerformanceTwoBundle:PerformanceTwo",
     * permission="VIEW"
     * )
     */
    public function updateAction(PerformanceTwo $performancetwo)
    {
        //$performancetwoRepository = $this->get('doctrine.')

        return $this->update($performancetwo);
    }

    /**
     * @param PerformanceTwo $performancetwo
     * @return array
     */
    protected function update(PerformanceTwo $performancetwo)
    {
        $request = $this->getRequest();
        $form = $this->createForm(new PerformanceTwoType(), $performancetwo);

        if ('POST' == $request->getMethod()) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($performancetwo);
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('stc.performancetwo.saved_message')
                );

                return $this->get('oro_ui.router')->actionRedirect(
                    array(
                        'route' => 'stc_performancetwo_update',
                        'parameters' => array('id' => $performancetwo->getId()),
                    ),
                    array(
                        'route' => 'stc_performancetwo_view',
                        'parameters' => array('id' => $performancetwo->getId()),
                    )
                );
            }
        }

        return array(
            'entity' => $performancetwo,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/dev", name="stc_performancetwo_dev")
     * @Acl(
     * id="stc_performancetwo_dev",
     * type="entity",
     * class="StcPerformanceTwoBundle:PerformanceTwo",
     * permission="VIEW"
     * )
     */
    public function devAction()
    {
        $view = $this->render('OroUIBundle:Default:index.html.twig');
        return $view;
    }

}