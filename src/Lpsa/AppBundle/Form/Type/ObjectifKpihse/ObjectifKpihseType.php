<?php

namespace Lpsa\AppBundle\Form\Type\ObjectifKpihse;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Translation\TranslatorInterface;
use Lpsa\AppBundle\Form\DataTransformer\TextToDecimalDataTransformer;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ObjectifKpihseManagerInterface;

class ObjectifKpihseType extends AbstractType
{
    /**
     *
     * @var TranslatorInterface $translator
     */
    protected $translator;
    /**
     * @var ObjectifKpihseManagerInterface $objectifKpihseManager
     */
    protected $objectifKpihseManager;

    public function __construct(TranslatorInterface $translator,ObjectifKpihseManagerInterface $objectifKpihseManager){
        $this->translator = $translator;
        $this->objectifKpihseManager = $objectifKpihseManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $formValidator = function (FormEvent $event) use ($entity){
            $form = $event->getForm();
            $year = $form->get('annee')->getData();
            if (!empty($year) || !empty($month)){ 
                $objectifKpihse = $this->objectifKpihseManager->getRepository()->findOneBy(array(
                    'annee' => $year
                ));
                $isExist = false;
                if($entity && $entity->getId()){
                    if($objectifKpihse && $entity->getId() !== $objectifKpihse->getId()){
                        $isExist = true;
                    }
                } else {
                    if($objectifKpihse){
                        $isExist = true;
                    }
                }
                if($isExist) {   
                    $form['annee']->addError(new FormError($this->translator->trans('form.errors.decanteur.monthYear', array(), 'LpsaAppBundle')));
                }
            }
        };
        $builder
            ->add('nbreFatLpsa',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreFatContracte',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreFatTiers',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreLtiLpsa',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreLtiContracte',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('rwc',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreMtLpsa',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreMtContracte',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreFaLpsa',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreFaContracte',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('tri',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('trir12Mois','text',array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('ltir12Mois','text',array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('trir','text',array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('ltir','text',array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('far','text',array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('far12Mois','text',array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreAccidentDepotAvecArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreAccidentTransportTerrestreAvecArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            /*->add('nbreLtiTransportTerrestreAvecArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))*/
            ->add('nbreAccidentTransportMaritimeAvecArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreAccidentSiegeAvecArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreAccidentDepotSansArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreAccidentTransportTerrestreSansArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreLtiTransportTerrestreSansArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreAccidentTransportMaritimeSansArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreAccidentSiegeSansArret',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreAgression',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreVol',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreIntrusion',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add(
                $builder->create('nbreJourDernierAccidentCorporelRoute','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('kmDernierAccidentCorporelRoute','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('nbreJourDernierAccidentCorporelRail','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('kmDernierAccidentCorporelRail','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('nbreJourDernierIncidentMaritime','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('milesDernierIncidentMaritime','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('nbreJourDernierFatalite','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('tauxSinistralite','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('kmVehiculeLeger','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('tauxSinistraliteVehiculeLeger','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add('nbreExercicePoi',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreExerciceMiniPoi',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreExercicePum',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreExerciceCombine',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreExerciceCmc',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreVisiteCodir',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreEvenementReporte',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add(
                $builder->create('indiceReporting','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add('nbrePresqueAccident',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreActeSituationDangereuse',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreIncidentPotentiel',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreAnalyseArbreCauseRealise',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('zoneEtancheSup159',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('zoneEtancheInf159',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('zoneNonEtancheSup159',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('zoneNonEtancheInf159',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('fuiteProduitNonMesurable',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('pollutionMarine',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('piezometreNbEchantillonPreleve',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('piezometreNbEchantillonAnalyse',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('piezometreNbAnomalieReleve',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add(
                $builder->create('piezometreTauxNonConformite','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add('decanteurNbEchantillonPreleve',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('decanteurNbEchantillonAnalyse',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('decanteurNbAnomalieReleve',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add(
                $builder->create('decanteurTauxNonConformite','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add('laboratoireNbEchantillonPreleve',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('laboratoireNbEchantillonAnalyse',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('laboratoireNbAnomalieReleve',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add(
                $builder->create('laboratoireTauxNonConformite','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add(
                $builder->create('laboratoireResultatEssaiCirculaire','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add('nbreNonConformiteCloture',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreNonConformiteNonEchue',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add('nbreOVERDUE',null,array(
                'required' => false,
                'empty_data' => 0
            ))
            ->add(
                $builder->create('pourcentageOVERDUE','text',array(
                    'attr' => array(
                        'class' => 'decimal'
                    ),
                    'required' => false,
                    'empty_data' => 0
                ))->addModelTransformer(new TextToDecimalDataTransformer())
            )
            ->add('annee')    
            ->addEventListener(FormEvents::SUBMIT, $formValidator)    
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\ObjectifKpihse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lpsa_appbundle_objectifkpihse';
    }


}
