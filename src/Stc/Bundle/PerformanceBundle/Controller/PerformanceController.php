<?php

namespace Stc\Bundle\PerformanceBundle\Controller;

use Stc\Bundle\PerformanceBundle\Event\Handler\PerformanceEventHandler;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Stc\Bundle\PerformanceBundle\Event\PerformanceEvent;
use Stc\Bundle\PerformanceBundle\EventListener\CreatePerformanceListener;
use Stc\Bundle\PerformanceBundle\Form\Handler\PerformanceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Oro\Bundle\UserBundle\Entity\User;
use Stc\Bundle\PerformanceBundle\Entity\Performance;
use Stc\Bundle\PerformanceBundle\Event\PerformanceEvents;
use Stc\Bundle\PerformanceBundle\Form\Type\PerformanceType;
use Symfony\Component\HttpFoundation\Response;
use Zend\Code\Reflection\DocBlock\TagManager;

use OroCRM\Bundle\SalesBundle\Entity\Lead;

/**
 * @Route("/performance")
 */
class PerformanceController extends Controller
{
    /**
     * @Route(
     * ".{_format}",
     * name="stc_performance_index",
     * requirements={"_format"="html|json"},
     * defaults={"_format" = "html"}
     * )
     * @Template
     * @Acl(
     * id="stc_performance_index",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function indexAction()
    {
        $page_data = array();
        $page_data['entity_name'] = "Performances";
        //$page_data['entity'] = new Performance();
        $performanceRepository = $this->getDoctrine()->getRepository('StcPerformanceBundle:Performance');

        $all = $performanceRepository->findAll();

        foreach ($all as $a) {
            $page_data['performances'][] = $a;
        }

        return array('page_data' => $page_data,
                     'entity' => new Performance());
    }

    /**
     * @Route("/info/{id}", name="stc_performance_info", requirements={"id"="\d+"})
     *
     * @Template
     * @AclAncestor("stc_performance_view")
     */
    public function infoAction(Performance $performance)
    {
        return array(
            'performance'  => $performance,
            'entity' => $performance
        );
    }


    /**
     * @Route("/view/{id}", name="stc_performance_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_performance_view",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function viewAction(Performance $performance)
    {
        return array('entity' => $performance);
    }

    /**
     * @Route("/fromlead/{lead_id}", name-"stc_performance_fromlead", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_performance_fromlead",
     * type="entity",
     * class="StcPerformanceBundle:Performance"
     * permission="CREATE"
     * )
     */
/*    public function fromleadAction()
    {
        $performance = new Performance();
        //$performance->
    }*/


    /**
     * @Route("/create", name="stc_performance_create")
     * @Template("StcPerformanceBundle:Performance:update.html.twig")
     * @Acl(
     * id="stc_performance_create",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="CREATE"
     * )
     */
    public function createAction()
    {
        $performance = new Performance();

        $token = $this->get('security.context')->getToken();
        //$username = $context->getUsername();
        $user = $token->getUser();

        $performance->setCreatedAt(new \DateTime('now'));
        $performance->setStatus(1);
        $performance->setDeleted(0);
        $performance->setAssignee($user);
        $performance->setOwner($user);

        return $this->update($performance);
    }

    /**
     * @Route("/update/{id}", name="stc_performance_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_performance_update",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function updateAction(Performance $performance)
    {
        $performanceRepository = $this->getDoctrine()->getManager()->getRepository('StcPerformanceBundle:Performance');

        $id = $this->getRequest()->get('id');

        $findPerformance = $performanceRepository->find($id);
        //print_r($findPerformance);exit;
        //return $this->update($performance);
        $result = $this->update($findPerformance);

        return $result;
    }

    /**
     * @param Performance $performance
     * @return array
     */
    protected function update(Performance $performance)
    {
        $request = $this->getRequest();
        $form = $this->createForm(new PerformanceType(), $performance);
        $formHandler = $this->get('stc_performance.form.handler');

        /*$formHandler = $this->get('stc_performance.form.handler');

        if ($formHandler->handle($form, $request)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator').trans('stc.performance.saved_message')
            );

            return $this->get('oro_ui.router')->actionRedirect(
                array(
                    'route' => 'stc_performance_update',
                    'parameters' => array('id' => $performance->getId()),
                ),
                array(
                    'route' => 'stc_performance_view',
                    'parameters' => array('id' => $performance->getId()),
                )
            );
        }*/

        if ('POST' === $request->getMethod()) {
            //$form->setData($performance);
            if ($formHandler->handle($performance)) {
                //handled in form handler:
                //$this->getDoctrine()->getManager()->persist($performance);
                //$this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('stc.performance.saved_message')
                );

                return $this->get('oro_ui.router')->redirectAfterSave(
                    array(
                        'route' => 'stc_performance_index',
                        'parameters' => array('id' => $performance->getId()),
                    ),
                    array(
                        'route' => 'stc_performance_index',
                        'parameters' => array('id' => $performance->getId()),
                    )
                );
            }
        }

        return array(
            'entity' => $performance,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/info", name="stc_performance_widgets_info")
     * @Template()
     * @Acl(
     * id="stc_performance_info",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function infoWidgetAction(Performance $performance)
    {
        return [
            'entity' => $performance
        ];
    }

    /**
     * @Route("/show/{id}", name="stc_performance_show", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("stc_performance_index")
     */
    public function showAction()
    {
        $id = $this->getRequest()->get('id');

        $performanceRepository = $this->getDoctrine()->getRepository('StcPerformanceBundle:Performance');

        $performance = $performanceRepository->find($id);

        return array(
            'entity' => $performance
        );
    }


    /**
     * @Route("/dev", name="stc_performance_dev")
     * @Acl(
     * id="stc_performance_dev",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function devAction()
    {
        $view = $this->render('OroUIBundle:Default:index.html.twig');
        return $view;
    }

    /**
     * @Route("/test", name="stc_performance_test")
     *
     */
    public function testAction()
    {
        $performance = $this->getDoctrine()->getRepository('StcPerformanceBundle:Performance')->find(1);
        $dispatcher = new EventDispatcher();

        $event = new PerformanceEvent($performance);

        $eventHandler = new PerformanceEventHandler($this->getDoctrine()->getManager());

        $listener = new CreatePerformanceListener($eventHandler);
        $listener->setContainer($this->container);
        $dispatcher->addListener('stc_performance.new_performance_created', array($listener, 'onPerformanceEvent'));

        $dispatcher->dispatch(PerformanceEvents::NEW_PERFORMANCE_CREATED, $event);

        //print_r($event);exit;

        return new Response();
    }

}