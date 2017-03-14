<?php

namespace Lpsa\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType{
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        
        $formValidator = function (FormEvent $event){
            $form = $event->getForm();
            $groups = $form->get('groups')->getData();
            if(count($groups) < 1){
                $form['groups']->addError(new FormError('Cette valeur ne doit pas être vide.'));   
            }
        };
        // custom field      
        $builder
            ->add('firstname', null, array('label' => 'form_label.user.firstname', 'translation_domain' => 'LpsaAppBundle'))
            ->add('lastname', null, array('label' => 'form_label.user.lastname', 'translation_domain' => 'LpsaAppBundle'))
            ->add('matricule', null, array('label' => 'form_label.user.matricule', 'translation_domain' => 'LpsaAppBundle'))
            ->add('direction','lpsa_select_ajax',array(
                'label' => 'form_label.user.direction',
                'translation_domain' => 'LpsaAppBundle',
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
                ),
                'constraints' => new NotBlank()
            ))
            ->add('departement','lpsa_select_ajax',array(
                'label' => 'form_label.user.departement',
                'translation_domain' => 'LpsaAppBundle',
                'required' => false,
                'entity_class_ajax' => 'LpsaAppBundle:Departement',
                'data_choice' => '',
                'all_data' => false,
                'ajax_route' => 'ajax_service',
                'js_data' => null,
                'js_selector' => '.select-departement',
                'js_var' => 'objDepartement',
                'attr' => array(
                    'class' => 'select-departement'
                )
            ))
            ->add('service','lpsa_select_ajax',array(
                'label' => 'form_label.user.service',
                'translation_domain' => 'LpsaAppBundle',
                'required' => false,
                'entity_class_ajax' => 'LpsaAppBundle:Service',
                'data_choice' => '',
                'all_data' => false,
                'ajax_route' => '',
                'js_data' => '',
                'js_selector' => '',
                'js_var' => 'objService',
                'attr' => array(
                    'class' => 'select-service'
                )
            ))
            ->add('fonction', 'entity', array(
                    'label' => 'Fonction',
                    'class' => 'LpsaAppBundle:Fonction',
                    'empty_value' => '--Select Fonction--',
                    'required' => false)
            )
            ->add('groups', 'entity', array(
                'class' => 'LpsaUserBundle:Group',
                'property' => 'name',
                'expanded' => true,
                'multiple' => true,
                'required' => true,
                'empty_value' => '--Select Group--',
                'constraints' => new NotBlank()
                )
            )->addEventListener(FormEvents::SUBMIT, $formValidator);
    }
 
    public function getName() {
        return 'lpsa_admin_user_registration';
    }
}
