<?php

namespace Lpsa\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Lpsa\AppBundle\Form\DataTransformer\AjaxSelectTransformer;

class SelectAjaxType extends AbstractType{
    
    /**
     * @var EntityManager
     */
    protected $em;
    
    /**
     *
     * @var RouterInterface 
     */
    protected $router;
    
    /**
     *
     * @var RequestStack 
     */
    protected $requestStack;


    /* construct.
     *
     * @param EntityManager $em
     * @param RouterInterface $router
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManager $em,RouterInterface $router,RequestStack $requestStack)
    {
        $this->em = $em;
        $this->router = $router;
        $this->requestStack = $requestStack;
    }
    
    /**
     * BuildForm.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new AjaxSelectTransformer($this->em, $options['entity_class_ajax']);
        $builder->addModelTransformer($transformer);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'entity_class_ajax',
            'data_choice',
            'all_data',
            'ajax_route',
            'js_selector',
            'js_data',
            'js_var'
            
        ]);
        $resolver->setDefaults(array(
            'check_request' => true
        ));
        $isCreateUpdate = $this->requestStack->getMasterRequest()->isMethod('POST') || $this->requestStack->getMasterRequest()->isMethod('PUT');
        $choices = function (Options $options) use($isCreateUpdate) {
            
            $entities = $this->em->getRepository($options['entity_class_ajax'])->findAll();
            $aChoices = array();
            foreach($entities as $entity){
                if((!$options['check_request'] || !$isCreateUpdate) && isset($options['data_choice']) && !empty($options['data_choice'])){
                    if($options['data_choice']->getParent() === $entity->getParent()){
                        $aChoices[$entity->getId()] = $entity->getLibelle();
                    }
                } elseif($options['all_data'] || $isCreateUpdate) {
                    $aChoices[$entity->getId()] = $entity->getLibelle();                    
                }
            }
            return $aChoices;
        };
        
        $resolver->setDefaults([
            'choices' => $choices
        ]);
    }
    
    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['ajax_url'] = (!empty($options['ajax_route'])) ? $this->router->generate($options['ajax_route']) : '';
        $view->vars['js_selector'] = $options['js_selector'];
        $view->vars['js_data'] = $options['js_data'];
        $view->vars['js_var'] = $options['js_var'];
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'lpsa_select_ajax';
    }
    
}
