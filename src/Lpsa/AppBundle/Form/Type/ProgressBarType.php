<?php

namespace Lpsa\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProgressBarType extends AbstractType{
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'number'
        ));
    }  
    
    public function getParent()
    {
        return 'number';
    }

    public function getName()
    {
        return 'lpsa_progress_bar';
    }
    
}
