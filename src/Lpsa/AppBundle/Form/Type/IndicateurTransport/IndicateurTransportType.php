<?php

namespace Lpsa\AppBundle\Form\Type\IndicateurTransport;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Translation\TranslatorInterface;
use Lpsa\AppBundle\Form\DataTransformer\TextToDecimalDataTransformer;
use Lpsa\AppBundle\Entity\Manager\Interfaces\IndicateurTransportManagerInterface;

class IndicateurTransportType extends AbstractType
{
    /**
     *
     * @var TranslatorInterface $translator
     */
    protected $translator;
    /**
     * @var IndicateurTransportManagerInterface $indicateurTransportManager
     */
    protected $indicateurTransportManager;

    public function __construct(TranslatorInterface $translator,IndicateurTransportManagerInterface $indicateurTransportManager){
        $this->translator = $translator;
        $this->indicateurTransportManager = $indicateurTransportManager;
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
            if (!empty($year) || !empty($month)){ 
                $indicateurTransport = $this->indicateurTransportManager->getRepository()->findOneBy(array(
                    'mois'  => $month,
                    'annee' => $year,
                    
                ));
                $isExist = false;
                if($entity && $entity->getId()){
                    if($indicateurTransport && $entity->getId() !== $indicateurTransport->getId()){
                        $isExist = true;
                    }
                } else {
                    if($indicateurTransport){
                        $isExist = true;
                    }
                }
                if($isExist) {
                    $form['mois']->addError(new FormError($this->translator->trans('form.errors.indicateurTransport.monthYear', array(), 'LpsaAppBundle')));   
                    $form['annee']->addError(new FormError($this->translator->trans('form.errors.indicateurTransport.monthYear', array(), 'LpsaAppBundle')));
                }
            }
        };
        $builder
            ->add(
                $builder->create('nbreJourAccidentCorporelTransportRoute','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('kmAccidentCorporelTransportRoute','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('nbreJourAccidentCorporelTransportRail','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('kmAccidentCorporelTransportRail','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('nbreJourIncidentTransportMaritime','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('kmIncidentTransportMaritime','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('nbreJourFatalite','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('tauxSinistraliteMatiereDangereuse','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('kmVehiculeLeger','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('tauxSinistraliteVehiculeLeger','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    )
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
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
            'data_class' => 'Lpsa\AppBundle\Entity\IndicateurTransport'
        ));
    }
}
