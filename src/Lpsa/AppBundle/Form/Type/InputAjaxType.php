<?php

namespace Lpsa\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

class InputAjaxType extends AbstractType{
    
    /**
     *
     * @var RouterInterface 
     */
    protected $router;
    
    /* construct.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'view_data',
            'data-id',
            'ajax_route',
            'hidden_target',
            'js_var'
        ]);
        $resolver->setDefaults(array(
            'widget' => 'single_text'
        ));
    }  
    
    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['ajax_url'] = $this->router->generate($options['ajax_route']);
        $view->vars['view_data'] = $options['view_data'];
        $view->vars['data_id'] = $options['data-id'];
        $view->vars['hidden_target'] = $options['hidden_target'];
        $view->vars['js_var'] = $options['js_var'];
        $view->vars['isRequired'] = isset($options['required']) ? $options['required'] : false;
    }
    
    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'lpsa_input_ajax';
    }
    
}
