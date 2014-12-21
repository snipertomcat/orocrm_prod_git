<?php

namespace Stc\Bundle\PerformanceTwoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PerformanceTwoType extends AbstractType
{
    /**
     * @var string
     */
    protected $performancetwoClass;

    /**
     * @param string $performancetwoClass
     */
    public function __construct($performancetwoClass = 'Stc\Bundle\PerformanceTwoBundle\Entity\PerformanceTwo')
    {
        $this->performancetwoClass = $performancetwoClass;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                'name',
                'text',
                array(
                    'label' => 'stc.performancetwo.name.label',
                    'required' => true,
                )
            )
            ->add(
                'description',
                'text',
                array(
                    'label' => 'stc.performancetwo.description.label',
                    'required' => false,
                )
            )
            ->add(
                'contacts',
                'orocrm_contact_select',
                array(
                    'required' => 'false',
                    'label' => 'stc.performancetwo.contacts.label'
                )
            )
            ->add(
                'assignee',
                'oro_user_select',
                array(
                    'required' => false,
                    'label' => 'stc.performancetwo.assignee.label'
                )
            )
            ->add(
                'profileType',
                'text',
                array(
                    'label' => 'stc.performancetwo.profileType.label',
                    'required' => false,
                )
            )
            ->add(
                'industry',
                'text',
                array(
                    'label' => 'stc.performancetwo.industry.label',
                    'required' => false,
                )
            )
            ->add(
                'annualReperformancetwo',
                'text',
                array(
                    'label' => 'stc.performancetwo.annualReperformancetwo.label',
                    'required' => false,
                )
            )
            ->add(
                'phoneFax',
                'text',
                array(
                    'label' => 'stc.performancetwo.phoneFax.label',
                    'required' => false,
                )
            )
            ->add(
                'billingAddressStreet',
                'text',
                array(
                    'label' => 'stc.performancetwo.billingAddressStreet.label',
                    'required' => true,
                )
            )
            ->add(
                'billingAddressCity',
                'text',
                array(
                    'label' => 'stc.performancetwo.billingAddressCity.label',
                    'required' => false,
                )
            )
            ->add(
                'billingAddressState',
                'text',
                array(
                    'label' => 'stc.performancetwo.billingAddressState.label',
                    'required' => false,
                )
            )
            ->add(
                'billingAddressPostalcode',
                'text',
                array(
                    'label' => 'stc.performancetwo.billingAddressPostalcode.label',
                    'required' => false,
                )
            )
            ->add(
                'billingAddressCountry',
                'text',
                array(
                    'label' => 'stc.performancetwo.country.label',
                    'required' => false,
                )
            )
            ->add(
                'rating',
                'text',
                array(
                    'label' => 'stc.performancetwo.rating.label',
                    'required' => false,
                )
            )
            ->add(
                'phoneOffice',
                'text',
                array(
                    'label' => 'stc.performancetwo.phoneOffice.label',
                    'required' => true,
                )
            )
            ->add(
                'phoneAlternate',
                'text',
                array(
                    'label' => 'stc.performancetwo.phoneAlternate.label',
                    'required' => false,
                )
            )
            ->add(
                'website',
                'text',
                array(
                    'label' => 'stc.performancetwo.website.label',
                    'required' => false,
                )
            )
            ->add(
                'ownership',
                'text',
                array(
                    'label' => 'stc.performancetwo.ownership.label',
                    'required' => false,
                )
            )
            ->add(
                'employees',
                'text',
                array(
                    'label' => 'stc.performancetwo.employees.label',
                    'required' => false,
                )
            )
            ->add(
                'tickerSymbol',
                'text',
                array(
                    'label' => 'stc.performancetwo.tickerSymbol.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressStreet',
                'text',
                array(
                    'label' => 'stc.performancetwo.shippingAddressStreet.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressCity',
                'text',
                array(
                    'label' => 'stc.performancetwo.shippingAddressCity.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressState',
                'text',
                array(
                    'label' => 'stc.performancetwo.shippingAddressState.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressPostalcode',
                'text',
                array(
                    'label' => 'stc.performancetwo.shippingAddressPostalcode.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressCountry',
                'text',
                array(
                    'label' => 'stc.performancetwo.shippingAddressCountry.label',
                    'required' => false,
                )
            )
            ->add(
                'performancetwoType',
                'text',
                array(
                    'label' => 'stc.performancetwo.performancetwoType.label',
                    'required' => false,
                )
            )
            ->add(
                'capacity',
                'text',
                array(
                    'label' => 'stc.performancetwo.capacity.label',
                    'required' => false,
                )
            )
            ->add(
                'ageLimit',
                'text',
                    array(
                    'label' => 'stc.performancetwo.ageLimit.label',
                    'required' => false,
                )
            )
            ->add(
                'avgTicketPrice',
                'text',
                array(
                    'label' => 'stc.performancetwo.avgTicketPrice.label',
                    'required' => false,
                )
            )
            ->add(
                'status',
                'text',
                array(
                    'label' => 'stc.performancetwo.staus.label',
                    'required' => false,
                )
            )
            ->add(
                'twitter',
                'text',
                array(
                    'label' => 'stc.performancetwo.twitter.label',
                    'required' => false,
                )
            )
            ->add(
                'facebook',
                'text',
                array(
                    'label' => 'stc.performancetwo.facebook.label',
                    'required' => false,
                )
            );
    }

    /**
     * @inheritdoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->performancetwoClass
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'stc_performancetwo';
    }
}