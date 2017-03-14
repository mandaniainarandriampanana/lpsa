<?php

namespace Lpsa\AppBundle\Form\Type\Piezometre;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Translation\TranslatorInterface;
use Lpsa\AppBundle\Form\DataTransformer\TextToDecimalDataTransformer;
use Lpsa\AppBundle\Entity\Manager\Interfaces\PiezometreManagerInterface;

class PiezometreType extends AbstractType
{
    /**
     *
     * @var TranslatorInterface $translator
     */
    protected $translator;
    /**
     * @var PiezometreManagerInterface $piezometreManager
     */
    protected $piezometreManager;

    public function __construct(TranslatorInterface $translator,PiezometreManagerInterface $piezometreManager){
        $this->translator = $translator;
        $this->piezometreManager = $piezometreManager;
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
                $piezometre = $this->piezometreManager->getRepository()->findOneBy(array(
                    'mois'  => $month,
                    'annee' => $year,
                    
                ));
                $isExist = false;
                if($entity && $entity->getId()){
                    if($piezometre && $entity->getId() !== $piezometre->getId()){
                        $isExist = true;
                    }
                } else {
                    if($piezometre){
                        $isExist = true;
                    }
                }
                if($isExist) {
                    $form['mois']->addError(new FormError($this->translator->trans('form.errors.piezometre.monthYear', array(), 'LpsaAppBundle')));   
                    $form['annee']->addError(new FormError($this->translator->trans('form.errors.piezometre.monthYear', array(), 'LpsaAppBundle')));
                }
            }
        };
        $builder
            ->add('nbreEchantillonPreleve')
            ->add('nbreEchantillonAnalyse')
            ->add('nbreAnomalieReleve')
            ->add(
                $builder->create('tauxNonConformite','text',array(
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
            'data_class' => 'Lpsa\AppBundle\Entity\Piezometre'
        ));
    }
}
