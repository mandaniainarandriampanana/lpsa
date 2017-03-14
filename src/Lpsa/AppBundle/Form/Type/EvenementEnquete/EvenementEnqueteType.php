<?php

namespace Lpsa\AppBundle\Form\Type\EvenementEnquete;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Lpsa\AppBundle\Form\DataTransformer\TextToDateTimeDataTransformer;
use Lpsa\AppBundle\Form\Type\EvenementEnquetePj\EvenementEnquetePjType;

class EvenementEnqueteType extends AbstractType
{    
    private $uploadFilesConstraints;
    private $translator;
    private $isAuthorized;
    
    public function __construct($uploadFilesConstraints,TranslatorInterface $translator,$isAuthorized)
    {
        $this->uploadFilesConstraints = $uploadFilesConstraints;
        $this->translator = $translator;
        $this->isAuthorized = $isAuthorized;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $concatClassDatepicker = ($this->isAuthorized) ? '' : ' datepicker-disable';        
        $builder
            ->add(
                $builder->create(
                    'date', 'lpsa_datepicker',
                    array(
                        'attr' => array('class' => 'datepicker evenementEnquete-date' . $concatClassDatepicker),
                        'required' => false,
                        'read_only' => true,
                        'label'    => 'form_label.evenementEnquete.date'
                    )
                )->addModelTransformer(new TextToDateTimeDataTransformer())
            )
            ->add('commentaire',null,array(
                'label' => 'form_label.evenementEnquete.commentaire',
                'disabled' => !$this->isAuthorized,
                'attr' => array(
                    'class' => 'evenementEnquete-commentaire'
                )
            ))
            ->add('causesImmediates',null,array(
                'label' => 'form_label.evenementEnquete.causesImmediates',
                'disabled' => !$this->isAuthorized,
                'attr' => array(
                    'class' => 'evenementEnquete-causesImmediates'
                )
            ))
            ->add('causesFondamentales',null,array(
                'label' => 'form_label.evenementEnquete.causesFondamentales',
                'disabled' => !$this->isAuthorized,
                'attr' => array(
                    'class' => 'evenementEnquete-causesFondamentales'
                )
            ))
            ->add('evenementEnquetePJs', 'collection',array(
                    'type'   => new EvenementEnquetePjType($this->uploadFilesConstraints,$this->translator),
                    'allow_add'=>true,
                    'by_reference' => false,
                    'allow_delete' => true,
                    'prototype' => true
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\EvenementEnquete',
            'translation_domain' => 'LpsaAppBundle'
        ));
    }
}
