<?php

namespace Stc\Bundle\SalesBundle\Controller;

use Stc\Bundle\SalesBundle\Event\LeadEvent;
use Stc\Bundle\SalesBundle\Event\LeadEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use OroCRM\Bundle\AccountBundle\Entity\Account;
use OroCRM\Bundle\SalesBundle\Entity\Lead;

/**
 * @Route("/lead")
 */
class LeadController extends Controller
{
    /**
     * @Route("/view/{id}", name="orocrm_sales_lead_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="orocrm_sales_lead_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="OroCRMSalesBundle:Lead"
     * )
     */
    public function viewAction(Lead $lead)
    {
        return array(
            'entity' => $lead
        );
    }

    /**
     * @Route("/info/{id}", name="orocrm_sales_lead_info", requirements={"id"="\d+"})
     * @AclAncestor("orocrm_sales_lead_view")
     * @Template()
     */
    public function infoAction(Lead $lead)
    {
        return array(
            'entity'  => $lead
        );
    }

    /**
     * @Route("/address-book/{id}", name="orocrm_sales_lead_address_book", requirements={"id"="\d+"})
     * @AclAncestor("orocrm_sales_lead_view")
     * @Template()
     */
    public function addressBookAction(Lead $lead)
    {
        return array(
            'entity' => $lead
        );
    }

    /**
     * Create lead form
     * @Route("/create", name="orocrm_sales_lead_create")
     * @Template("OroCRMSalesBundle:Lead:update.html.twig")
     * @Acl(
     *      id="orocrm_sales_lead_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="OroCRMSalesBundle:Lead"
     * )
     */
    public function createAction()
    {
        $lead = new Lead();
        $accountId = $this->getRequest()->get('account');
        if ($accountId) {
            $repository = $this->getDoctrine()->getRepository('OroCRMAccountBundle:Account');
            /** @var Account $account */
            $account = $repository->find($accountId);
            if ($account) {
                /** @var Lead $lead */
                $lead->setAccount($account);
            } else {
                throw new NotFoundHttpException(sprintf('Account with ID %s is not found', $accountId));
            }
        }

        return $this->update($lead);
    }

    /**
     * Update user form
     * @Route("/update/{id}", name="orocrm_sales_lead_update", requirements={"id"="\d+"}, defaults={"id"=0})
     *
     * @Template
     * @Acl(
     *      id="orocrm_sales_lead_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="OroCRMSalesBundle:Lead"
     * )
     */
    public function updateAction(Lead $entity)
    {
        return $this->update($entity);
    }

    /**
     * @Route(
     *      "/{_format}",
     *      name="orocrm_sales_lead_index",
     *      requirements={"_format"="html|json"},
     *      defaults={"_format" = "html"}
     * )
     * @Template
     * @AclAncestor("orocrm_sales_lead_view")
     */
    public function indexAction()
    {
        return [
            'entity_class' => $this->container->getParameter('orocrm_sales.lead.entity.class')
        ];
    }

    /**
     * @Route("/widget/account-leads/{id}", name="orocrm_sales_widget_account_leads", requirements={"id"="\d+"})
     * @AclAncestor("orocrm_sales_lead_view")
     * @Template()
     */
    public function accountLeadsAction(Account $account)
    {
        return array('entity' => $account);
    }

    /**
     * @param Lead $entity
     *
     * @return array
     */
    protected function update(Lead $entity)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $eventDispatcher = $this->get('event_dispatcher');

        $event = new LeadEvent($entity);

        $eventDispatcher->dispatch(
            LeadEvents::NEW_LEAD_CREATED,
            $event
        );

        return $this->get('oro_form.model.update_handler')->handleUpdate(
            $entity,
            $this->get('orocrm_sales.lead.form'),
            function (Lead $entity) {
                return array(
                    'route' => 'orocrm_sales_lead_update',
                    'parameters' => array('id' => $entity->getId())
                );
            },
            function (Lead $entity) {
                return array(
                    'route' => 'orocrm_sales_lead_view',
                    'parameters' => array('id' => $entity->getId())
                );
            },
            $this->get('translator')->trans('orocrm.sales.controller.lead.saved.message'),
            $this->get('orocrm_sales.lead.form.handler')
        );
    }
}
