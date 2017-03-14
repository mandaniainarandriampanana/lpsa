<?php

namespace Lpsa\AppBundle\Form\Type\Paq3se;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Doctrine\Common\Persistence\ObjectManager;
use Lpsa\AppBundle\Form\DataTransformer\TextToDateTimeDataTransformer;

class Paq3seType extends AbstractType
{
    private $manager;
    private $isPaqssse;
    private $isAuthorized;
    private $evenement;

    public function __construct(ObjectManager $manager,$isPaqssse,$evenement,$isAuthorized)
    {
        $this->manager = $manager;
        $this->isPaqssse = $isPaqssse;
        $this->isAuthorized = $isAuthorized;
        $this->evenement = $evenement;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isPaqssse = $this->isPaqssse;
        $formValidator = function (FormEvent $event) use($isPaqssse){
            $form = $event->getForm();
            $frequence = $form->get('frequence')->getData();
            $gravite = $form->get('gravite')->getData();
            if($isPaqssse){
                if($frequence === null){
                    $form['frequence']->addError(new FormError("Veuillez indiquer la frequence"));
                }
                if($gravite == null){
    //                    $form['gravite']->addError(new FormError("Veuillez indiquer la gravite"));
                }
                $realisation = $form->get('realisation')->getData();
                if(!is_float($realisation) || $realisation<0 || $realisation>100){
                    $form['realisation']->addError(new FormError("La realisation est un nombre 0 à 100"));
                }
                if($form->get('anomalieConstate')->getData() === null){
                    $form['anomalieConstate']->addError(new FormError('Cette valeur ne doit pas être vide.'));
                }
            }
        };
        $gravities = $this->manager->getRepository('LpsaAppBundle:Gravite')->findAll();
        $choiceGravities = array('');
        foreach($gravities as $gravity){
            $choiceGravities[$gravity->getValeur()] = $gravity->getLibelle();
        }
        $concatClassDatepicker = ($this->isAuthorized) ? '' : ' datepicker-disable';
        $builder
                ->add('gravite','choice', array(
                    'choices' => $choiceGravities,
                    'multiple' => false, 
                    'expanded' => false, 
                    'disabled' => true,
                    'mapped' => false,
                    'data' => ($this->evenement->getGravite()) ? $this->evenement->getGravite()->getValeur() : ''
                        )
                    )
                ->add('frequence',IntegerType::class,array(
                    'attr' => array('class' => 'number'),
                    'required' => false,
                    'disabled' => !$this->isAuthorized
                ))
                ->add('niveauRisque',null,array(
                    'label' => 'Niveau de risque',
                    'read_only' => true,
                    'required' => false,
                    'disabled' => !$this->isAuthorized
                ))
                ->add('priorite',null,array(
                    'read_only' => true,
                    'required' => false,
                ))
                ->add(
                    $builder->create(
                        'dateFin','lpsa_datepicker',array(
                            'label' => 'Date fin au plus tard',
                            'attr' => array('class' => 'datepicker' . $concatClassDatepicker),
                            'read_only' => true,
                            'required' => true
                        )
                    )
                    ->addModelTransformer(new TextToDateTimeDataTransformer())
                )
                ->add('realisation',PercentType::class,array(
                    'type' => 'integer',
                    'required' => false,
                    'disabled' => !$this->isAuthorized
                ))
                ->add('anomalieConstate',null,array(
                    'required' => false,
                    'disabled' => !$this->isAuthorized,
                ))
                ->add('action',null,array(
                    'required' => false,
                    'disabled' => !$this->isAuthorized
                ))->addEventListener(FormEvents::SUBMIT, $formValidator)
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\Paq3se'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lpsa_appbundle_paq3se';
    }


}
