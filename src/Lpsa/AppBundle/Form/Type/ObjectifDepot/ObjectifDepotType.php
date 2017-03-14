<?php

namespace Lpsa\AppBundle\Form\Type\ObjectifDepot;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lpsa\AppBundle\Form\DataTransformer\TextToDateTimeDataTransformer;
use Symfony\Component\Validator\Constraints\NotBlank;

class ObjectifDepotType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('objectif')
                ->add(
                    $builder->create(
                        'dateDebut', 'lpsa_datepicker',
                        array(
                            'attr' => array('class' => 'datepicker readonly required'),
                            'required' => true,
                            'constraints' => new NotBlank()
                        )
                    )->addModelTransformer(new TextToDateTimeDataTransformer())
                )
                ->add(                    
                    $builder->create(
                        'dateFin', 'lpsa_datepicker',
                        array(
                            'attr' => array('class' => 'datepicker readonly required'),
                            'required' => true,
                            'constraints' => new NotBlank()
                        )
                    )->addModelTransformer(new TextToDateTimeDataTransformer())
                )
                ->add('depot',null,array(
                    'constraints' => new NotBlank()
                ))        
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\ObjectifDepot'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lpsa_appbundle_objectifdepot';
    }


}
