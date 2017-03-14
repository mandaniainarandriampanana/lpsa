<?php

namespace Lpsa\AppBundle\Form\Type\HeureTravail;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Translation\TranslatorInterface;
use Lpsa\AppBundle\Entity\Manager\HeureTravailManager;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Lpsa\AppBundle\Form\DataTransformer\TextToDecimalDataTransformer;

class HeureTravailType extends AbstractType
{
    /**
     *
     * @var HeureTravailManager 
     */
    private $heureTravailManager;
    
    /**
     * @var TranslatorInterface
     */
    protected $translator;
    
    /**
     * 
     * @param HeureTravailManager $heureTravailManager
     * @param TranslatorInterface $translator
     */
    public function __construct(HeureTravailManager $heureTravailManager,TranslatorInterface $translator) {
        $this->heureTravailManager = $heureTravailManager;
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $hour = $builder->getData();
        $formValidator = function (FormEvent $event) {
            $form = $event->getForm();
            $month = $form->get('mois')->getData();
            $year = $form->get('annee')->getData();
            $id = $form->get('id')->getData();
            $heureTravailCategorie=$form->get('heureTravailCategorie')->getData();
            if (!empty($year) || !empty($month) || !empty($heureTravailCategorie)){ 
                $heureTravail = $this->heureTravailManager->getRepository()->findBy(array(
                    'mois'  => $month,
                    'annee' => $year,
                    'heureTravailCategorie' => $heureTravailCategorie,
                ));
                $isHisId =  $this->heureTravailManager->getRepository()->findBy(array(
                    'mois'  => $month,
                    'annee' => $year,
                    'heureTravailCategorie' => $heureTravailCategorie,
                    'id' => $id
                    ));
                if($heureTravail && empty($isHisId)){
                    $form['mois']->addError(new FormError($this->translator->trans('form.errors.heureTravail.monthYearCategorie', array(), 'LpsaAppBundle')));   
                    $form['annee']->addError(new FormError($this->translator->trans('form.errors.heureTravail.monthYearCategorie', array(), 'LpsaAppBundle')));
                    $form['heureTravailCategorie']->addError(new FormError($this->translator->trans('form.errors.heureTravail.monthYearCategorie', array(), 'LpsaAppBundle')));
                }
            }
        };
        $builder
            ->add(
                    $builder->create('heure','text',array(
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
                
            ->add('annee','lpsa_year_choice',array(
                'year_choice' => ($hour) ? $hour->getAnnee() : null
            ))
            ->add('heureTravailCategorie','entity',array(
                'class' => 'LpsaAppBundle:HeureTravailCategorie',
                'property' => 'libelle',
            ))
            ->add('id',HiddenType::class,array(
                'required' => false
            ))
            ->addEventListener(FormEvents::SUBMIT, $formValidator)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\HeureTravail'
        ));
    }
    public function getName()
    {        
        return 'heuretravail';
    }
}
