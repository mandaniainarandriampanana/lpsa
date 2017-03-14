<?php

namespace Lpsa\AppBundle\Form\Type\EvenementActionProgres;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lpsa\AppBundle\Form\DataTransformer\TextToDateTimeDataTransformer;

class EvenementActionProgresType extends AbstractType
{
    private $isAuthorized;
    public function __construct($isAuthorized){
        $this->isAuthorized = $isAuthorized;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $concatClassDatepicker = ($this->isAuthorized) ? '' : ' datepicker-disable';
        $concatClassSelect = ($this->isAuthorized) ? '' : ' select-readonly select-readonly-strict';
        $builder
            ->add('action',null,array(
                'required' => false,
                'disabled' => !$this->isAuthorized,
                'attr' => array(
                    'class' => 'actionProgres-action'
                )
            ))
            ->add('responsableService',null,array(
                'required' => false,
                'attr' => array(
                    'class' => 'actionProgres-responsableService' . $concatClassSelect
                )
            ))
            ->add(
                $builder->create(
                    'delai', 'lpsa_datepicker',
                    array(
                        'label' => false,
                        'attr' => array('class' => 'datepicker actionProgres-delai' . $concatClassDatepicker),
                        'required' => false                        
                    )
                )
                ->addModelTransformer(new TextToDateTimeDataTransformer())
            )
            ->add('avancement','lpsa_progress_bar',array(
                'required' => false,
                'disabled' => !$this->isAuthorized,
                'attr' => array(
                    'class' => 'actionProgres-avancement number percent'
                )
            ))
            ->add('observation',null,array(
                'required' => false,
                'disabled' => !$this->isAuthorized,
                'attr' => array(
                    'class' => 'actionProgres-observation'
                )
            ))
            ->add('evenementActionProgresStatus',null,array(
                'required' => false,
                'attr' => array(
                    'class' => 'actionProgres-evenementActionProgresStatus' . $concatClassSelect
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\EvenementActionProgres'
        ));
    }
}
