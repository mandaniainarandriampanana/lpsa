<?php

namespace Lpsa\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class UserEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $user = $builder->getData();
        $direction=null;
        if($user){
            $direction = $user->getDirection();
        }
        $departement=null;
        if($user){
            $departement = $user->getDepartement();
        }
        $service=null;
        if($user){
            $service = $user->getService();
        }
        $formValidator = function (FormEvent $event){
            $form = $event->getForm();
            $groups = $form->get('groups')->getData();
            if(count($groups) < 1){
                $form['groups']->addError(new FormError('Cette valeur ne doit pas être vide.'));   
            }
        };
        $builder
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('firstname', null, array('label' => 'form_label.user.firstname', 'translation_domain' => 'LpsaAppBundle'))
            ->add('lastname', null, array('label' => 'form_label.user.lastname', 'translation_domain' => 'LpsaAppBundle'))
            ->add('matricule')
            ->add('email', null, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('enabled', null,array('label' => 'form.enabled', 'translation_domain' => 'FOSUserBundle'))
            // DEBUT CHAMP AJAX
            ->add('direction','lpsa_select_ajax',array(
                'label' => 'form_label.user.direction',
                'translation_domain' => 'LpsaAppBundle',
                'required' => false,
                'all_data' => true,
                'data_choice' => '',
                'entity_class_ajax' => 'LpsaAppBundle:Direction',
                'ajax_route' => 'ajax_departement',
                'js_data' => ($direction) ? $direction->getId() : null,
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
                'data_choice' => $departement,
                'all_data' => false,
                'ajax_route' => 'ajax_service',
                'js_data' => ($departement) ? $departement->getId() : null,
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
                'data_choice' => $service,
                'all_data' => false,
                'ajax_route' => '',
                'js_data' => ($service) ? $service->getId() : null,
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
                'empty_value' => '--Select Group--')
            )->addEventListener(FormEvents::SUBMIT, $formValidator)
                ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\UserBundle\Entity\User'
        ));
    }
}
