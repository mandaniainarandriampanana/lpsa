<?php

namespace Lpsa\AppBundle\Form\Type\ResponsableService;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableServiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $responsableService = $builder->getData();
        
        $builder
            ->add('libelle')
            ->add('direction','lpsa_select_ajax',array(
                'label' => 'form_label.responsableservice.direction',
                'required' => false,
                'all_data' => true,
                'data_choice' => '',
                'entity_class_ajax' => 'LpsaAppBundle:Direction',
                'ajax_route' => 'ajax_departement',
                'js_data' => null,
                'js_selector' => '.select-direction',
                'js_var' => 'objDirection',
                'attr' => array(
                    'class' => 'select-direction'
                )
            ))
            ->add('departement','lpsa_select_ajax',array(
                'label' => 'form_label.responsableservice.departement',
                'required' => false,
                'entity_class_ajax' => 'LpsaAppBundle:Departement',
                'data_choice' => $responsableService->getDepartement(),
                'all_data' => false,
                'ajax_route' => 'ajax_service',
                'js_data' => null,
                'js_selector' => '.select-department',
                'js_var' => 'objDepartment',
                'attr' => array(
                    'class' => 'select-department'
                )
            ))
            ->add('service','lpsa_select_ajax',array(
                'label' => 'form_label.responsableservice.service',
                'required' => false,
                'entity_class_ajax' => 'LpsaAppBundle:Service',
                'data_choice' => $responsableService->getService(),
                'all_data' => false,
                'ajax_route' => '',
                'js_data' => null,
                'js_selector' => '',
                'js_var' => 'objService',
                'attr' => array(
                    'class' => 'select-service'
                )
            ))
            ->add('users',null,array(
                'expanded' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\ResponsableService',
            'translation_domain' => 'LpsaAppBundle'
        ));
    }
}
