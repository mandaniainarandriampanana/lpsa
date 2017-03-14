<?php

namespace Lpsa\AppBundle\Form\Type\Toolbox;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ToolboxManagerInterface;
use Lpsa\AppBundle\Form\Type\ToolboxPj\ToolboxPjType;

class ToolboxType extends AbstractType
{
    /**
     *
     * @var TranslatorInterface $translator
     */
    protected $translator;
    /**
     * @var ToolboxManagerInterface $toolboxManager
     */
    protected $toolboxManager;

    private $container;

    public function __construct(TranslatorInterface $translator,ToolboxManagerInterface $toolboxManager, Container $container){
        $this->translator = $translator;
        $this->toolboxManager = $toolboxManager;
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $formValidator = function (FormEvent $event) use ($entity){
            $form = $event->getForm();
            $month = $form->get('mois')->getData();
            $year = $form->get('annee')->getData();
            $depot = $form->get('depot')->getData();
            if (!empty($year) || !empty($month)){ 
                $toolbox = $this->toolboxManager->getRepository()->findOneBy(array(
                    'mois'  => $month,
                    'annee' => $year,
                    'depot' => $depot
                ));
                $isExist = false;
                if($entity && $entity->getId()){
                    if($toolbox && $entity->getId() !== $toolbox->getId()){
                        $isExist = true;
                    }
                } else {
                    if($toolbox){
                        $isExist = true;
                    }
                }
                if($isExist) {
                    $form['mois']->addError(new FormError($this->translator->trans('form.errors.toolbox.monthYear', array(), 'LpsaAppBundle')));   
                    $form['annee']->addError(new FormError($this->translator->trans('form.errors.toolbox.monthYear', array(), 'LpsaAppBundle')));
                }
                if(empty($depot)){
                    $form['depot']->addError(new FormError($this->translator->trans('form.errors.blank', array(), 'LpsaAppBundle')));   
                }
            }
        };
        $uploadFilesConstraints = $this->container->getParameter('upload_files_constraints');
        $builder
            ->add('depot','entity',[
                'label' => 'Dépôt',
                'class' => 'LpsaAppBundle:Depot',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.libelle', 'ASC');
                }
            ])
            ->add('siege',null,[
                'label' => 'Nombre siège',
                'required' => false
            ])
            ->add('depots',null,[
                'label' => 'Nombre dépôt',
                'required' => false
            ])
            ->add('toolboxPjs', 'collection',array(
                    'type'   => new ToolboxPjType($uploadFilesConstraints,$this->translator),
                    'allow_add'=>true,
                    'by_reference' => false,
                    'allow_delete' => true,
                    'prototype' => true
                )
            )
            ->add('sct')
            ->add('mois','choice', array('choices' => array(1 => "Janvier", 2 => "Février", 3 => "Mars", 4 => "Avril", 5 => "Mai", 6 => "Juin"
                                                            ,7 => "Juillet",8 =>"Août",9 =>"Septembre",10 =>"Octobre",11 =>"Novembre",12 =>"Décembre"), 
                    'multiple' => false, 
                    'expanded' => false, 
                    'empty_value' => '- Choisissez le mois -',
                    'empty_data'  => -1
                )
            )
            ->add('annee')
            ->addEventListener(FormEvents::SUBMIT, $formValidator)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\Toolbox'
        ));
    }
}
