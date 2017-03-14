<?php

namespace Lpsa\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class FileType extends AbstractType{
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'route_name'
        ));
        $resolver->setDefaults(array(
            'display' => true
        ));
    }  
    
    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['display'] = $options['display'];
        $view->vars['route_name'] = $options['route_name'];
    }
    
    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'lpsa_file';
    }
    
}
