<?php

namespace Lpsa\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->add('roles', 'choice', array(
                    'label' => 'Rôles : ',
                    'multiple' => true,
                    'expanded' => true,
                    'required' => true,
                    'choices'  => array(
                            'ROLE_SUPER_ADMIN' => 'Super Administrateur',
                            'ROLE_ADMIN' => 'Administrateur',
                            'ROLE_USER' => 'Utilisateur',
                            'ROLE_KPIHSE' => 'Utilisateur KPI HSE',
                            'ROLE_VISITE' => 'Utilisateur KPI Visite',
                            'ROLE_EXERCICE_URGENCE' => 'Utilisateur KPI Exercice urgence',
                            'ROLE_TOOLBOX' => 'Utilisateur KPI Toolbox',
                            'ROLE_PIEZOMETRE' => 'Utilisateur KPI Piézomètre',
                            'ROLE_DECANTEUR' => 'Utilisateur KPI Décanteur',
                            'ROLE_LABORATOIRE' => 'Utilisateur KPI Laboratoire',
                            'ROLE_INDICATEUR_TRANSPORT' => 'Utilisateur KPI Indicateur transport',
                            'ROLE_OBJECTIF_KPI' => 'Utilisateur Objectif KPI',
                            'ROLE_PAQSSSE' => 'Utilisateur PAQSSSE'
                    ))
            )
            ->add('depot');
    }
 
    public function getParent()
    {
        return 'fos_user_group';
    }
 
    public function getName()
    {
        return 'lpsa_admin_user_group';
    }
}
