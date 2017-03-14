<?php

namespace Lpsa\AppBundle\Form\Type\ExerciceUrgence;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ExerciceUrgenceManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ExerciceUrgenceType extends AbstractType
{
    /**
     *
     * @var TranslatorInterface $translator
     */
    protected $translator;
    /**
     * @var ExerciceUrgenceManagerInterface $exerciceUrgenceManager
     */
    protected $exerciceUrgenceManager;

    public function __construct(TranslatorInterface $translator,ExerciceUrgenceManagerInterface $exerciceUrgenceManager){
        $this->translator = $translator;
        $this->exerciceUrgenceManager = $exerciceUrgenceManager;
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
                $exerciceUrgence = $this->exerciceUrgenceManager->getRepository()->findOneBy(array(
                    'mois'  => $month,
                    'annee' => $year,
                    'depot' => $depot
                ));
                $isExist = false;
                if($entity && $entity->getId()){
                    if($exerciceUrgence && $entity->getId() !== $exerciceUrgence->getId()){
                        $isExist = true;
                    }
                } else {
                    if($exerciceUrgence){
                        $isExist = true;
                    }
                }
                if($isExist) {
                    $form['mois']->addError(new FormError($this->translator->trans('form.errors.exerciceUrgence.monthYear', array(), 'LpsaAppBundle')));   
                    $form['annee']->addError(new FormError($this->translator->trans('form.errors.exerciceUrgence.monthYear', array(), 'LpsaAppBundle')));
                }
                if(empty($depot)){
                    $form['depot']->addError(new FormError($this->translator->trans('form.errors.blank', array(), 'LpsaAppBundle')));   
                }
            }
        };
        $builder
            ->add('depot','entity',[
                'label' => 'Dépôt',
                'class' => 'LpsaAppBundle:Depot',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.libelle', 'ASC');
                }
            ])
            ->add('nbrePoi')
            ->add('nbreMiniPoi')
            ->add('nbrePum')
            ->add('nbreCombine')
            ->add('nbreCmc')
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
            'data_class' => 'Lpsa\AppBundle\Entity\ExerciceUrgence'
        ));
    }
}
