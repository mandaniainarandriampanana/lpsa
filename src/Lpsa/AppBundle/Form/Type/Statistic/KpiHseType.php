<?php

namespace Lpsa\AppBundle\Form\Type\Statistic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Lpsa\AppBundle\Form\DataTransformer\TextToDateTimeDataTransformer;
use Lpsa\AppBundle\Statistic\StatisticDataBinding;

class KpiHseType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator){
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formValidator = function (FormEvent $event){
            $form = $event->getForm();
            $dateStart = $form->get('dateStart')->getData();
            $dateEnd = $form->get('dateEnd')->getData(); 
            if($dateStart && !$dateEnd){
                $form['dateEnd']->addError(new FormError($this->translator->trans('form.errors.blank', array(), 'LpsaAppBundle')));
            } elseif(!$dateStart && $dateEnd){
                $form['dateStart']->addError(new FormError($this->translator->trans('form.errors.blank', array(), 'LpsaAppBundle')));
            } elseif($dateStart && $dateEnd){
                $yearStart = intval($dateStart->format('Y'));
                $yearEnd = intval($dateEnd->format('Y'));
                if($yearStart > $yearEnd){
                    $form['dateStart']->addError(new FormError($this->translator->trans('form.errors.statistic.kpihse.maxYear', array('year_end' => $yearEnd), 'LpsaAppBundle')));
                }
                if($yearEnd - $yearStart > 1){
                    $form['dateStart']->addError(new FormError($this->translator->trans('form.errors.statistic.kpihse.period', array(), 'LpsaAppBundle')));
                    $form['dateEnd']->addError(new FormError($this->translator->trans('form.errors.statistic.kpihse.period', array(), 'LpsaAppBundle')));
                } else {
                    $dayEnd = intval($dateEnd->format('d'));
                    $monthEnd = intval($dateEnd->format('m'));
                    $dayStart = intval($dateStart->format('d'));
                    $monthStart = intval($dateStart->format('m'));
                    if(($monthEnd === 12) && ($dayEnd > StatisticDataBinding::MONTH_DAY_END)){
                        $form['dateEnd']->addError(new FormError($this->translator->trans('form.errors.statistic.kpihse.monthDayEnd', array('month_day_end' => StatisticDataBinding::MONTH_DAY_END), 'LpsaAppBundle')));
                    }
                    if(($monthStart === 12) && ($dayStart < StatisticDataBinding::MONTH_DAY_START) && ($monthStart !== $monthEnd)){
                        $form['dateStart']->addError(new FormError($this->translator->trans('form.errors.statistic.kpihse.monthDayStart', array('month_day_start' => StatisticDataBinding::MONTH_DAY_START), 'LpsaAppBundle')));
                    }
                    if(($yearStart < $yearEnd) && (($monthStart < 12) || ($dayStart > StatisticDataBinding::MONTH_DAY_START && ($monthStart < 12)))){
                        $form['dateEnd']->addError(new FormError($this->translator->trans('form.errors.statistic.kpihse.monthDayEnd', array('month_day_end' => StatisticDataBinding::MONTH_DAY_END), 'LpsaAppBundle')));
                        $form['dateStart']->addError(new FormError($this->translator->trans('form.errors.statistic.kpihse.monthDayStart', array('month_day_start' => StatisticDataBinding::MONTH_DAY_START), 'LpsaAppBundle')));
                    }
                }
            }
        };
        $builder
                ->add(
                    $builder->create(
                        'dateStart', 'lpsa_datepicker',
                        array(
                            'label' => 'De:',
                            'attr' => array('class' => 'datepicker'),
                            'required' => false
                        )
                    )->addModelTransformer(new TextToDateTimeDataTransformer())
                )
                ->add(                    
                    $builder->create(
                        'dateEnd', 'lpsa_datepicker',
                        array(
                            'label' => 'A:',
                            'attr' => array('class' => 'datepicker'),
                            'required' => false
                        )
                    )->addModelTransformer(new TextToDateTimeDataTransformer())
                )
                ->add('btnFilter', SubmitType::class, array(
                    'label' => 'Filtrer',
                    'attr' => array(
                        'class' => 'btn btn-default'
                    )
                ))
                ->add('btnReset', SubmitType::class, array(
                    'label' => 'Reset',
                    'attr' => array(
                        'class' => 'btn btn-default'
                    )
                ))
                ->add('btnExport', SubmitType::class, array(
                    'label' => 'Export',
                    'attr' => array(
                        'class' => 'btn btn-default'
                    )
                ))
                ->addEventListener(FormEvents::SUBMIT, $formValidator)     
                ;
    }

    public function getName()
    {
        return 'lpsa_kpihse_filter';
    }
}
