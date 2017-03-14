<?php

namespace Lpsa\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType{
    
    public function buildUserForm(FormBuilderInterface $builder, array $options) {
        parent::buildUserForm($builder, $options);
 
        // custom field      
        $builder
            ->add('firstname', null, array('label' => 'form_label.user.firstname', 'translation_domain' => 'LpsaAppBundle'))
            ->add('lastname', null, array('label' => 'form_label.user.lastname', 'translation_domain' => 'LpsaAppBundle'));
    }
 
    public function getName() {
        return 'lpsa_admin_user_profile';
    }
}
