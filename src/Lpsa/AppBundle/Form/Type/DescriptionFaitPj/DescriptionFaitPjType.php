<?php

namespace Lpsa\AppBundle\Form\Type\DescriptionFaitPj;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Translation\TranslatorInterface;

class DescriptionFaitPjType extends AbstractType
{
    private $uploadConstraits;
    private $translator;
    
    public function __construct($uploadConstraits,TranslatorInterface $translator){
        $this->uploadConstraits = $uploadConstraits;
        $this->translator = $translator;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file','lpsa_file',array(
                'label' => false,
                'display' => false,
                'route_name' => 'download_description_attachment',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => $this->uploadConstraits['maxSize'],
                        'mimeTypes' => $this->uploadConstraits['mimeTypes'],
                        'mimeTypesMessage' => $this->translator->trans('form.errors.mimeTypes', array(), 'LpsaAppBundle')
                    ])
                ]
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\DescriptionFaitPj'
        ));
    }
}
