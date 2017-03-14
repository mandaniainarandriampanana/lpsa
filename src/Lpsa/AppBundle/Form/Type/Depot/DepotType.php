<?php

namespace Lpsa\AppBundle\Form\Type\Depot;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepotType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('sigle')
            ->add('responsableEmailCdd','text',array('required' => false))
            ->add('responsableEmailAdm','text',array('required' => false))
            ->add('depotcategories', 'entity', array(
                'class' => 'LpsaAppBundle:DepotCategorie',
                'property' => 'libelle',
                ));
        }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\Depot'
        ));
    }
}
