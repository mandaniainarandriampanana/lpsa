<?php

namespace Lpsa\AppBundle\Form\Type\Evenement;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Lpsa\AppBundle\Form\Type\EvenementActionProgres\EvenementActionProgresType;
use Lpsa\AppBundle\Form\Type\EvenementEnquete\EvenementEnqueteType;
use Lpsa\AppBundle\Form\DataTransformer\TextToDateTimeDataTransformer;
use Lpsa\AppBundle\Form\DataTransformer\TextToEntityDataTransformer;
use Lpsa\AppBundle\Form\DataTransformer\TextToIntegerDataTransformer;
use Lpsa\AppBundle\Form\DataTransformer\ValueToEntityDataTransformer;
use Lpsa\AppBundle\Form\Type\NarrationPj\NarrationPjType;
use Lpsa\AppBundle\Form\Type\Paq3se\Paq3seType;
use Lpsa\AppBundle\Form\Type\DescriptionFaitPj\DescriptionFaitPjType;
use Doctrine\Common\Persistence\ObjectManager;

class EvenementType extends AbstractType
{
    private $manager;
    private $evenementcategorieIds;
    private $uploadFilesConstraints;
    private $container;
    private $translator;
    private $requestStack;

    public function __construct(ObjectManager $manager, Container $container,TranslatorInterface $translator,RequestStack $requestStack)
    {
        $this->manager = $manager;
        $this->uploadFilesConstraints = $container->getParameter('upload_files_constraints');
        $this->container = $container;
        $this->translator = $translator;
        //category type 
        $consequenceReelle = $manager->getRepository('LpsaAppBundle:TypeEvenementCategorie')->findOneById(1);
        $consequencePotentielle = $manager->getRepository('LpsaAppBundle:TypeEvenementCategorie')->findOneById(2);
        $evenementcategorieIds = array();
        foreach($consequenceReelle->getEvenementCategories() as $real){
            $evenementcategorieIds['consequenceReelle'][] = $real->getId();
        }
        foreach($consequencePotentielle->getEvenementCategories() as $risk){
            $evenementcategorieIds['consequencePotentielle'][] = $risk->getId();
        }
        $this->evenementcategorieIds = $evenementcategorieIds;
        $this->requestStack = $requestStack;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $evenement = $builder->getData();
        $container = $this->container;
        $request = $this->requestStack->getMasterRequest();
        $formValidator = function (FormEvent $event) use($container) {
            $form = $event->getForm();
            $typeCorporel = $form->get('typeCorporel')->getData();
            $typecorporelIds = $container->getParameter('typecorporel_ids');
            $corporel = $form->get('corporel')->getData(); 
            if($typeCorporel && is_object($typeCorporel) && $corporel){
                $totalMax = $corporel->getTotalMax();
                if($totalMax > 0){
                    foreach($typecorporelIds as $typeCorpoId){
                        if($typeCorpoId['id'] === $typeCorporel->getId()){
                            $count = 0;
                            $fields = array();
                            foreach($typeCorpoId['nbre'] as $nbre){
                                $fields[] = $nbre;
                                $count += $form->get($nbre)->getData();
                            }
                            if(!empty($fields) && ($count > $totalMax)){
                                foreach($fields as $field){
                                    $form[$field]->addError(new FormError($this->translator->trans('form.errors.evenement.maxTotal', array('total_max' => $totalMax), 'LpsaAppBundle')));   
                                }
                            }
                            break;
                        }
                    }   
                }
            } 
            $evenementActionProgres = $form->get('evenementActionProgres')->getData();
            foreach($evenementActionProgres as $key => $action){
                if($action->getId() === null){
                    if($action->getAction() || $action->getObservation() || $action->getResponsableService() 
                            || $action->getEvenementActionProgresStatus() || $action->getDelai() || $action->getAvancement()){
                        if(empty($action->getAction())){
                            $form['evenementActionProgres'][$key]['action']->addError(new FormError($this->translator->trans('form.errors.blank', array(), 'LpsaAppBundle')));   
                        }
                        if(empty($action->getResponsableService() )){
                            $form['evenementActionProgres'][$key]['responsableService']->addError(new FormError($this->translator->trans('form.errors.blank', array(), 'LpsaAppBundle')));   
                        }
                        if(empty($action->getDelai() )){
                            $form['evenementActionProgres'][$key]['delai']->addError(new FormError($this->translator->trans('form.errors.blank', array(), 'LpsaAppBundle')));   
                        }
                        if(empty($action->getEvenementActionProgresStatus())){
                            $form['evenementActionProgres'][$key]['evenementActionProgresStatus']->addError(new FormError($this->translator->trans('form.errors.blank', array(), 'LpsaAppBundle')));   
                        }
                    }
                }
            }
            
        };
        $isAuthorized = true;
        if($evenement && $evenement->getId()){
            $isAuthorized = $this->container->get('security.authorization_checker')->isGranted('edit', $evenement);
        }
        $concatClassDatepicker = ($isAuthorized) ? '' : ' datepicker-disable';
        $concatClassSelect = ($isAuthorized) ? '' : ' select-readonly select-readonly-strict';
        $userDeclarant = null;
        $isCreateUpdate = $request->isMethod('POST') || $request->isMethod('PUT');
        if($isCreateUpdate){
            $postEvent = $request->request->get('evenement');
            if(isset($postEvent['userDeclarant']) && !empty($postEvent['userDeclarant']) && (intval($postEvent['userDeclarant']) > 0)){
                $userDeclarant = $this->manager->getRepository('LpsaUserBundle:User')->findOneById(intval($postEvent['userDeclarant']));
            }
        } 
        if($evenement && empty($userDeclarant)){
            $userDeclarant = $evenement->getUserDeclarant();
        }
        $isPaqssse = false;
        if($this->requestStack->getMasterRequest()->isMethod('POST')){
            $isPaqssse = $this->requestStack->getMasterRequest()->query->get('evenement')['isPaqssse'];
        }
        $builder
            ->add('paq3se', new Paq3seType($this->manager,$isPaqssse,$evenement,$isAuthorized),array(
                'required' => false,
            ))
            ->add('isPaqssse', CheckboxType::class, array(
                'label'    => 'Ajouter aux PAQSSSE?',
                'required' => false,
                'disabled' => !$isAuthorized
            ))
            ->add(
                $builder->create(
                    'dateEmission', 'text',
                    array(
                        'label' => 'form_label.evenement.dateEmission',
                        'required' => true,
                        'read_only' => true,
                        'attr' => array(
                            'class' => 'input-dateEmission' . $concatClassDatepicker
                        )
                    )
                )->addModelTransformer(new TextToDateTimeDataTransformer(true))
            )
            ->add(
                $builder->create(
                    'dateDesFaits', 'lpsa_datepicker',
                    array(
                        'label' => 'form_label.evenement.dateDesFaits',
                        'attr' => array('class' => 'datepicker input-dateDesFaits readonly required' . $concatClassDatepicker),
                        'required' => true
                        
                    )
                )
                ->addModelTransformer(new TextToDateTimeDataTransformer())
            )
            ->add(
                $builder->create(
                    'dateAction', 'lpsa_datepicker',
                    array(
                        'label' => 'form_label.evenement.dateAction',
                        'attr' => array('class' => 'datepicker input-dateAction' . $concatClassDatepicker),
                        'required' => false,
                        'read_only' => true
                    )
                )
                ->addModelTransformer(new TextToDateTimeDataTransformer())
            )
            ->add(
                $builder->create(
                    'dateCloture', 'text',
                    array(
                        'label' => 'form_label.evenement.dateCloture',
                        'disabled' => true,
                        'required' => false,
                        'read_only' => true,
                        'attr' => array(
                            'class' => 'input-dateCloture'
                        )
                    )
                )
                ->addModelTransformer(new TextToDateTimeDataTransformer())
            )
            
            ->add(
                $builder->create('userDeclarant','lpsa_input_ajax',
                    array(
                        'label' => 'form_label.evenement.userDeclarant',
                        'view_data' => $userDeclarant,
                        'data-id' => 'declarant',
                        'ajax_route' => 'lpsa_admin_user_declarantjson',
                        'js_var' => 'objUserDeclarant',
                        'hidden_target' => '.user-declarant',
                        'disabled' => !$isAuthorized,
                        'attr' => array(
                            'class' => 'user-declarant required'
                        )
                    )
                )
                ->addModelTransformer(new TextToEntityDataTransformer($this->manager,'LpsaUserBundle:User'))
            )
            ->add('categorie',null,array(
                'label' => 'form_label.evenement.categorie',
                'expanded' => true,
                'required' => true,
                'disabled' => !$isAuthorized,
                'attr'     => array(
                    'class' => 'event-categorie required'
                )
            ))            
            ->add('dysfonctionnement',null,array(
                'label' => $this->getMatrixGravityLabel($evenement, 'dysfonctionnement'),
                'attr'  => array(
                    'class' => 'select-dysfonctionnement' . $concatClassSelect
                )
            ))
            ->add('impactClient',null,array(
                'label' => $this->getMatrixGravityLabel($evenement, 'impactClient'),
                'attr'  => array(
                    'class' => 'select-impactclient' . $concatClassSelect
                )
            ))
            ->add('impactMediatique',null,array(
                'label' => $this->getMatrixGravityLabel($evenement, 'impactMediatique'),
                'attr'  => array(
                    'class' => 'select-impactmediatique' . $concatClassSelect
                )
            ))
            ->add('evenementStatut',null,array(
                'label' => 'form_label.evenement.evenementStatut',
                'attr'  => array(
                    'class' => 'select-evenementStatut' . $concatClassSelect
                )
            ))
            ->add('evenementEnquete', new EvenementEnqueteType($this->uploadFilesConstraints,$this->translator,$isAuthorized),array(
                'required' => false
            ))
            ->add('evenementActionProgres', 'collection', array(
                'type' => new EvenementActionProgresType($isAuthorized),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => 'evtActionProgres__name__',
            ))
            ->add(
                $builder->create('nbreLpsa','text',array(
                    'label' => 'form_label.evenement.nbreLpsa',
                    'required' => false,
                    'disabled' => !$isAuthorized,
                    'attr'  => array(
                        'class' => 'input-nbreLpsa number'
                    )
                ))
                ->addModelTransformer(new TextToIntegerDataTransformer())
            )
            ->add(
                $builder->create('nbreContracte','text',array(
                    'label' => 'form_label.evenement.nbreContracte',
                    'required' => false,
                    'disabled' => !$isAuthorized,
                    'attr'  => array(
                        'class' => 'input-nbreContracte number'
                    )
                ))
                ->addModelTransformer(new TextToIntegerDataTransformer())
            )
            ->add(
                $builder->create('nbreTiers','text',array(
                    'label' => 'form_label.evenement.nbreTiers',
                    'required' => false,
                    'disabled' => !$isAuthorized,
                    'attr'  => array(
                        'class' => 'input-nbreTiers number'
                    )
                ))
                ->addModelTransformer(new TextToIntegerDataTransformer())
            )
            ->add('typeAccident',null,array(
                'label' => false,
                'expanded' => true,
                'required' => true,
                'disabled' => !$isAuthorized,
                'attr'     => array(
                    'class' => 'event-TypeAccident'
                )
            ))
            ->add('typeSituationDangereuse',null,array(
                'label' => false,
                'expanded' => true,
                'required' => true,
                'disabled' => !$isAuthorized,
                'attr'     => array(
                    'class' => 'event-typeSituationDangereuse'
                )
            ))
            ->add('nbreEnvironnement',null,array(
                'label' => 'form_label.evenement.m3',
                'required' => false,
                'disabled' => !$isAuthorized,
                'attr' => array(
                    'class' => 'input-nbreEnvironnement decimal'
                )
            ))
            ->add('descriptionFait',null,array(
                'label' => false,
                'required' => false,
                'disabled' => !$isAuthorized,
                'attr'  => array(
                    'class' => 'input-descriptionFait'
                )
            ))
            ->add('descriptionFaitPJs', 'collection',array(
                    'type'   => new DescriptionFaitPjType($this->uploadFilesConstraints,$this->translator),
                    'allow_add'=>true,
                    'by_reference' => false,
                    'allow_delete' => true,
                    'prototype' => true
                )
            )
            ->add('narration',null,array(
                'label' => 'form_label.evenement.narration',
                'required' => false,
                'disabled' => !$isAuthorized,
                'attr'  => array(
                    'class' => 'input-narration'
                )
            ))
            ->add('narrationPJs', 'collection',array(
                    'type'   => new NarrationPjType($this->uploadFilesConstraints,$this->translator),
                    'allow_add'=>true,
                    'by_reference' => false,
                    'allow_delete' => true,
                    'prototype' => true
                )
            )
            ->add('numeroEnregistrement', null,array(
                    'label' => 'form_label.evenement.numeroEnregistrement',
                    'required' => true,
                    'read_only' => true,
                    'attr' => array(
                        'class' => 'numero-enregistrement'
                    )
                )
            )
        ;
        $corporel = null;
        $materiel = null;
        $environnement = null;
        $depot = null;
        if($isCreateUpdate){
            $postEvent = $request->request->get('evenement');
            if(isset($postEvent['corporel']) && !empty($postEvent['corporel']) && (intval($postEvent['corporel']) > 0)){
                $corporel = $this->manager->getRepository('LpsaAppBundle:Corporel')->findOneById(intval($postEvent['corporel']));
            }
            if(isset($postEvent['materiel']) && !empty($postEvent['materiel']) && (intval($postEvent['materiel']) > 0)){
                $materiel = $this->manager->getRepository('LpsaAppBundle:Materiel')->findOneById(intval($postEvent['materiel']));
            }
            if(isset($postEvent['environnement']) && !empty($postEvent['environnement']) && (intval($postEvent['environnement']) > 0)){
                $environnement = $this->manager->getRepository('LpsaAppBundle:Environnement')->findOneById(intval($postEvent['environnement']));
            }
            if(isset($postEvent['depot']) && !empty($postEvent['depot']) && (intval($postEvent['depot']) > 0)){
                $depot = $this->manager->getRepository('LpsaAppBundle:Depot')->findOneById(intval($postEvent['depot']));
            }
        } 
        if($evenement && empty($corporel)){
            $corporel = $evenement->getCorporel();
        }
        if($evenement && empty($materiel)){
            $materiel = $evenement->getMateriel();
        }
        if($evenement && empty($environnement)){
            $environnement = $evenement->getEnvironnement();
        }
        if($evenement && empty($depot)){
            $depot = $evenement->getDepot();
        }            
        $builder
            ->add(
                $builder->create('typeCorporel','lpsa_select_ajax',array(
                    'label' => $this->getMatrixGravityLabel($evenement, 'typeCorporel'),
                    'required' => false,
                    'mapped' => false,
                    'all_data' => true,
                    'data_choice' => '',
                    'check_request' => false,
                    'entity_class_ajax' => 'LpsaAppBundle:TypeCorporel',
                    'ajax_route' => 'ajax_corporel',
                    'js_data' => ($corporel) ? $corporel->getTypeCorporel()->getId() : null,
                    'data' => ($corporel) ? $corporel->getTypeCorporel() : null,
                    'js_selector' => '.select-typeCorporel',
                    'js_var' => 'objTypeCorporel',
                    'attr' => array(
                        'class' => 'select-typeCorporel' . $concatClassSelect
                    )
                ))->addModelTransformer(new ValueToEntityDataTransformer($this->manager,'LpsaAppBundle:TypeCorporel'))
            )
            ->add('corporel','lpsa_select_ajax',array(
                'label' => false,
                'required' => false,
                'entity_class_ajax' => 'LpsaAppBundle:Corporel',
                'data_choice' => $corporel,
                'check_request' => false,
                'all_data' => false,
                'ajax_route' => '',
                'js_data' => '',
                'js_selector' => '',
                'js_var' => 'objCorporel',
                'attr' => array(
                    'class' => 'select-corporel' . $concatClassSelect
                )
            ))
            ->add('typeMateriel','lpsa_select_ajax',array(
                'label' => $this->getMatrixGravityLabel($evenement, 'typeMateriel'),
                'required' => false,
                'mapped' => false,
                'all_data' => true,
                'check_request' => false,
                'data_choice' => '',
                'entity_class_ajax' => 'LpsaAppBundle:TypeMateriel',
                'ajax_route' => 'ajax_materiel',
                'js_data' => ($materiel) ? $materiel->getTypeMateriel()->getId() : null,
                'data' => ($materiel) ? $materiel->getTypeMateriel() : null,
                'js_selector' => '.select-typeMateriel',
                'js_var' => 'objTypeMateriel',
                'attr' => array(
                    'class' => 'select-typeMateriel' . $concatClassSelect
                )
            ))
            ->add('materiel','lpsa_select_ajax',array(
                'label' => false,
                'required' => false,
                'entity_class_ajax' => 'LpsaAppBundle:Materiel',
                'data_choice' => $materiel,
                'check_request' => false,
                'all_data' => false,
                'ajax_route' => '',
                'js_data' => '',
                'js_selector' => '',
                'js_var' => 'objMateriel',
                'attr' => array(
                    'class' => 'select-materiel' . $concatClassSelect
                )
            ))
            ->add('typeEnvironnement','lpsa_select_ajax',array(
                'label' => $this->getMatrixGravityLabel($evenement, 'typeEnvironnement'),
                'required' => false,
                'mapped' => false,
                'all_data' => true,
                'check_request' => false,
                'data_choice' => '',
                'entity_class_ajax' => 'LpsaAppBundle:TypeEnvironnement',
                'ajax_route' => 'ajax_environnement',
                'js_data' => ($environnement) ? $environnement->getTypeEnvironnement()->getId() : null,
                'data' => ($environnement) ? $environnement->getTypeEnvironnement() : null,
                'js_selector' => '.select-typeEnvironnement',
                'js_var' => 'objTypeEnvironnement',
                'attr' => array(
                    'class' => 'select-typeEnvironnement' . $concatClassSelect
                )
            ))
            ->add('environnement','lpsa_select_ajax',array(
                'label' => false,
                'required' => false,
                'entity_class_ajax' => 'LpsaAppBundle:Environnement',
                'data_choice' => $environnement,
                'check_request' => false,
                'all_data' => false,
                'ajax_route' => '',
                'js_data' => '',
                'js_selector' => '',
                'js_var' => 'objEnvironnement',
                'attr' => array(
                    'class' => 'select-environnement' . $concatClassSelect
                )
            ))
            ->add('depotCategorie','lpsa_select_ajax',array(
                'label' => 'form_label.evenement.zone',
                'required' => false,
                'mapped' => false,
                'all_data' => true,
                'check_request' => false,
                'data_choice' => '',
                'entity_class_ajax' => 'LpsaAppBundle:DepotCategorie',
                'ajax_route' => 'ajax_depot',
                'js_data' => ($depot) ? $depot->getDepotcategories()->getId() : null,
                'data' => ($depot) ? $depot->getDepotcategories() : null,
                'js_selector' => '.select-depotCategorie',
                'js_var' => 'objDepotCategorie',
                'attr' => array(
                    'class' => 'select-depotCategorie select-required required' . $concatClassSelect
                )
            ))
            ->add('depot','lpsa_select_ajax',array(
                'label' => 'form_label.evenement.site',
                'required' => false,
                'entity_class_ajax' => 'LpsaAppBundle:Depot',
                'data_choice' => $depot,
                'check_request' => false,
                'all_data' => false,
                'ajax_route' => '',
                'js_data' => '',
                'js_selector' => '',
                'js_var' => 'objDepot',
                'attr' => array(
                    'class' => 'select-depot select-required required' . $concatClassSelect
                )
            ))->addEventListener(FormEvents::SUBMIT, $formValidator)
        ;
    }
    
    /**
     * get label for matrix gravity element
     * 
     * @param Evenement $evenement
     * @param string $type
     * @return string
     */
    private function getMatrixGravityLabel($evenement,$type){
        $categorie = $evenement->getCategorie();
        $isRisk = $this->isCategoryRisk($categorie);
        if($type === 'typeCorporel'){
            if(!$isRisk){
                return 'form_label.evenement.typeCorporel';
            } else {
                return 'form_label.evenement.risque.corporel';
            }
            
        }
        if($type === 'typeMateriel'){
            if(!$isRisk){
                return 'form_label.evenement.typeMateriel';
            } else {
                return 'form_label.evenement.risque.materiel';
            }
            
        }
        if($type === 'typeEnvironnement'){
            if(!$isRisk){
                return 'form_label.evenement.typeEnvironnement';
            } else {
                return 'form_label.evenement.risque.environnemental';
            }
            
        }
        if($type === 'impactMediatique'){
            if(!$isRisk){
                return 'form_label.evenement.mediatique';
            } else {
                return 'form_label.evenement.risque.mediatique';
            }
            
        }
        if($type === 'impactClient'){
            if(!$isRisk){
                return 'form_label.evenement.impactClient';
            } else {
                return 'form_label.evenement.risque.qualite';
            }
            
        }
        if($type === 'dysfonctionnement'){
            if(!$isRisk){
                return 'form_label.evenement.dysfonctionnement';
            } else {
                return 'form_label.evenement.risque.dysfonctionnement';
            }
            
        }
        return '';
    }
    
    private function isCategoryRisk($categorie){
        if($categorie){
            foreach($this->evenementcategorieIds as $key => $ids){
                if(in_array($categorie->getId(), $ids) && ($key === 'consequencePotentielle')){
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lpsa\AppBundle\Entity\Evenement',
            'translation_domain' => 'LpsaAppBundle'
        ));
    }
}
