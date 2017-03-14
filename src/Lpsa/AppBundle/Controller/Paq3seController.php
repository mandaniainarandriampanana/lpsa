<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Evenement;
use Lpsa\CoreBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Session\Session;
use Lpsa\AppBundle\Statistic\Excel\SheetPaqssse;
/**
 * Evenement controller.
 *
 */
class Paq3seController extends CoreController
{
    /**
     * Lists all Evenement entities.
     *
     */
    public function indexAction(Request $request)
    {

        /**
         * mis en session du contenu du formulaire recherche
         */
        if($request->getMethod() == 'POST' && $request->request->get('rechercher')){
            $declarantId = null;
            $declarantText = '';
            if($request->get('declarant')){
                $em = $this->getDoctrine()->getManager();
                $declarant = $em->getRepository('LpsaUserBundle:User')->findOneById(intval($request->get('declarant')));
                if($declarant){
                    $declarantId = $declarant->getId();
                    $declarantText = $declarant->getLabelToPrint();
                }
            }
            $form=array(
                'niveauRisque' => $request->get('niveauRisque'),
                'priorite' => $request->get('priorite'),
                'idDepotCategorie'=>$request->get('zone'),
                'idDepot' => $request->get('site'),  
                'idEvenementCategorie' => $request->get('evenementCategorie'),
                'idEvenementStatut' => $request->get('statut'),
                'idResponsableservice' => $request->get('responsableservice'),
                'debutEmission' => $request->get('debutEmission'),
                'finEmission' => $request->get('finEmission'),
                'debutFaits' => $request->get('debutFaits'),
                'finFaits' => $request->get('finFaits'),
                'debutEnquete' => $request->get('debutEnquete'),
                'finEnquete' => $request->get('finEnquete'),
                'declarantId'  => $declarantId,
                'declarantText'  => $declarantText,
                    );

            $serialized_array=serialize($form);
            $this->get('app.function_helper')->sessionHelper(true,false,false,'formRecherche',$serialized_array);
        }
        if($request->getMethod() == 'POST' && $request->request->get('reset')){
            $this->get('app.function_helper')->sessionHelper(false,false,true,'formRecherche',null);
            $this->get('app.function_helper')->sessionHelper(false,false,true,'list_event_pager',null);
        }
        $obj = $this->get('app.function_helper')->sessionHelper(false,true,false,'formRecherche',null);
        $originalArray=unserialize($obj);
        
        $afficheForm = $this->isOriginalArray($originalArray); // gestion affichage formulaire
        
        //add session pager
        $page = $request->query->getInt('page', 1);    
        $this->get('app.function_helper')->sessionHelper(true,false,false,'list_event_pager',$page);
        $query = $this->getEvenementManager()->getRepository()->search($originalArray,$this->get('app.function_helper'),true);
        $paginator  = $this->get('knp_paginator');
        $evenements = $paginator->paginate(
            $query, /* query NOT result */
            $page/*page number*/,
            $this->getParameter('nb_event_per_page')
        );
        
        $afficheAlertNoResults = $this->afficheAlertNoResults($query,$request); // gestion affichage Alert No Results
        
        $depots=$this->getDepotManager()->getRepository()->findAll();
        $depotCategories = $this->getDepotCategorieManager()->getRepository()->findAll();
        $evenementStatuts = $this->getEvenementStatutManager()->getRepository()->findAll();
        $evenementCategories = $this->getEvenementCategorieManager()->getRepository()->findAll();
        $responsableServices=$this->getResponsableServiceManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Evenement:index.html.twig', array(
            'evenements' => $evenements,
            'depots' => $depots,
            'depotCategories' => $depotCategories,
            'evenementStatuts' => $evenementStatuts,
            'evenementCategories' => $evenementCategories,
            'responsableServices' => $responsableServices,
            'contenuFormulaire' => $originalArray,
            'afficheForm' => $afficheForm,
            'afficheAlertNoResults' => $afficheAlertNoResults,
            'isPaq3se' => true
        ));
    }
    public function editAction(Request $request, Evenement $evenement)
    {

        $evenementProcess = $this->getEvenementFormHandler()->processForm($evenement);
        
        
        if($request->isMethod('GET')){
            $hasAccess = $this->get('security.authorization_checker')->isGranted('edit', $evenementProcess);
            $form = $this->getEvenementFormHandler()->createForm($evenementProcess,'admin_paq3se_edit',$hasAccess);
        } else {
            $this->denyAccessUnlessGranted('edit', $evenementProcess); 
            $form = $this->getEvenementFormHandler()->createForm($evenementProcess,'admin_paq3se_edit',true);
        }
        
        
        return $this->renderViewNewEdit($request, $evenementProcess,$form);
    }
    
    private function renderViewNewEdit(Request $request,Evenement $evenementProcess,$form){
 
        if ($this->getEvenementFormHandler()->handleForm($form, $evenementProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getEvenementFormHandler()->getMessage());
 
            return $this->redirectToRoute('admin_paq3se_edit', array('id' => $evenementProcess->getId()));
        }
        $em = $this->getDoctrine()->getManager();
        $evenementCategorieTables = $em->getRepository('LpsaAppBundle:EvenementCategorieTable')->findAll();
        $gravityAbstractLabel = $this->getGravityLabel($evenementProcess->getCorporel(), $evenementProcess->getMateriel(), $evenementProcess->getEnvironnement(), $evenementProcess->getImpactMediatique(), $evenementProcess->getImpactClient(), $evenementProcess->getDysfonctionnement());
        $environmentVisibles = $this->getEnvironnementManager()->getRepository()->findAllEnvironnementWhereInputIsVisible();
        $environment1m3Ids = array();
        foreach ($environmentVisibles as $env){
            $environment1m3Ids[] = $env->getId();
        }
        //category type 
        $consequenceReelle = $this->getDoctrine()->getRepository('LpsaAppBundle:TypeEvenementCategorie')->findOneById(1);
        $consequencePotentielle = $this->getDoctrine()->getRepository('LpsaAppBundle:TypeEvenementCategorie')->findOneById(2);
        $evenementcategorieIds = array();
        foreach($consequenceReelle->getEvenementCategories() as $real){
            $evenementcategorieIds['consequenceReelle'][] = $real->getId();
        }
        foreach($consequencePotentielle->getEvenementCategories() as $risk){
            $evenementcategorieIds['consequencePotentielle'][] = $risk->getId();
        }
        $paramCategoriesId = $this->container->getParameter('categories_id');
        $paqssseGravity = $this->get('app.paq3seGravite.manager')->getRepository()->findOneGravity();
        return $this->render('LpsaAppBundle:Evenement:newEdit.html.twig', array(
            'form' => $form->createView(),
            'evenement' => $evenementProcess,
            'evenementCategorieTables' => $this->sortEvenementCategorieTables($evenementCategorieTables),
            'gravityAbstractLabel' => $gravityAbstractLabel,
            'environment1m3Ids' => $environment1m3Ids,
            'evenementcategorieIds' => $evenementcategorieIds,
            'paramCategoriesId' => $paramCategoriesId,
            'isPaq3se' => true,
            'paqssseGravity' => $paqssseGravity
        )); 
    }
    
    /**
     * Sort array of EvenementCategorieTable
     * 
     * @param mixed $evenementCategorieTables
     * @return array
     */
    private function sortEvenementCategorieTables($evenementCategorieTables){
        $newEvenementCategorieTables = array();
        foreach($evenementCategorieTables as $evenementCategorieTable){
            $categoryEvent = $evenementCategorieTable->getEvenementCategorie();
            if(!$categoryEvent){
                continue;
            }
            $categoryId = $categoryEvent->getId();
            if(!array_key_exists($categoryId, $newEvenementCategorieTables)){
                $newEvenementCategorieTables[$categoryId] = array($evenementCategorieTable->getNomTable());
            } else {
                $old = $newEvenementCategorieTables[$categoryId];
                $old[] = $evenementCategorieTable->getNomTable();
                $newEvenementCategorieTables[$categoryId] = $old;
            }
        }
        return $newEvenementCategorieTables;
    }
    /**
     * Delete a Evenement entity.
     *
     */
    public function deleteAction(Request $request,Evenement $evenement)
    {
        $this->denyAccessUnlessGranted('delete', $evenement);
        
        $this->getEvenementManager()->remove($evenement);
        $this->addFlash('success', $this->get('translator')->trans('evenement.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_paq3se');
    }
    
    public function searchAction(Request $request){
        $evenementManager=$this->get('app.evenement.manager');
        $evenements = $this->getEvenementManager()->getRepository()->search($request,$evenementManager);
        return $this->render('LpsaAppBundle:Evenement:index.html.twig', array(
            'evenements' => $evenements,
        ));
    }
    public function speedSearchAction(Request $request){
        $numeroEnregistrement=$request->query->get('numeroEnregistrement');
        $evenements=$this->getEvenementManager()->getRepository()->speedSearch($numeroEnregistrement);
        return $this->render('LpsaAppBundle:Evenement:index.html.twig', array(
            'evenements' => $evenements,
        ));
    }
    public function doublonAction(){
        $em = $this->getDoctrine()->getManager();
        $RAW_QUERY = "SELECT u.`firstname`, u.`lastname`, u.`matricule`, e.`date_emission`, p2.anomalieConstate,e.`depot_id`,d2.`libelle`, e.id FROM evenement e JOIN user u ON u.id = e.`user_id` JOIN depot d2 ON d2.id = e.`depot_id` JOIN `paq3se` p2 ON p2.evenement_id = e.`id` JOIN (SELECT paq.anomalieConstate,evt.`depot_id`,COUNT(*) ct FROM evenement evt JOIN depot d ON d.id = evt.`depot_id` JOIN `paq3se` paq ON paq.evenement_id = evt.`id` WHERE evt.is_paqssse = 1 GROUP BY paq.anomalieConstate, evt.`depot_id` HAVING COUNT(*) > 1) cte ON e.`depot_id`=cte.`depot_id` AND p2.anomalieConstate=cte.anomalieConstate ORDER BY e.`depot_id`";
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $result = $statement->fetchAll();
        return $this->render('LpsaAppBundle:Evenement:doublon.html.twig', array(
            'paqssses' => $result,
        ));
        
    }
    /**
     * 
     * @return type
     * 
     */
    public function exportAction(){
        $obj = $this->get('app.function_helper')->sessionHelper(false,true,false,'formRecherche',null);
        $originalArray=unserialize($obj);
        $paqssses = $this->getEvenementManager()->getRepository()->search($originalArray,$this->get('app.function_helper'),true)->getResult();
        if(empty($paqssses)){
            return $this->redirectToRoute('admin_paq3se');
        }
        $manager = $this->get('app.document.excel_manager');
        $sheetPaqssse = new SheetPaqssse($paqssses,$manager);
        $sheetPaqssse->process();
        $excelDocument = $manager->getDocument();
        $writer = $manager->createWriter($excelDocument, 'Excel2007');
        $now = new \DateTime();
        return $manager->outStreamResponse($writer,'paqssse au '.$now->format('d-m-Y').'.xlsx');
    }
    /**
     * 
     * @param type $originalArray
     * @return boolean
     */
    public function isOriginalArray($originalArray){
        if($originalArray){
            foreach ($originalArray as $key => $value){
                if($value!="" || $value !=null){
                    return true;
                }
            }
        }
        return false;
    }
    /**
     * 
     * @param type $query
     * @param type $request
     * @return boolean
     */
    public function afficheAlertNoResults($query,$request){
        if(empty($query->getResult()) && $request->getMethod() == 'POST' && $request->request->get('rechercher')){
            return true;
        }
        return false;
    }
    /**
     * 
     * @return type
     */
    public function getEvenementFormHandler()
    {
        return $this->get('app.evenement.form.handler');
    }
    public function deleteDoublonAction(Request $request,Evenement $evenement)
    {
        $this->denyAccessUnlessGranted('delete', $evenement);
        
        $this->getEvenementManager()->remove($evenement);
        $this->addFlash('success', $this->get('translator')->trans('evenement.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_paq3se_doublon');
    }
}
