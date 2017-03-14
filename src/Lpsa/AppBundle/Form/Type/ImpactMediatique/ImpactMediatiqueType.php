<?php

namespace Lpsa\AppBundle\Form\Type\ImpactMediatique;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImpactMediatiqueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('gravite','entity',array(
                'class'=>'LpsaAppBundle:Gravite',
                'property'=>'libelle'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\ImpactMediatique'
        ));
    }
}
