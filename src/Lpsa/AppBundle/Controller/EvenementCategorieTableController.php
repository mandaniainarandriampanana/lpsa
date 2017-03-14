<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Lpsa\AppBundle\Entity\EvenementCategorieTable;

/**
 * EvenementCategorieTable controller.
 *
 */
class EvenementCategorieTableController extends Controller
{
    /**
     * Lists all EvenementCategorieTable entities.
     *
     */
    public function indexAction()
    {              
        $data  = $this->prepareData();

        return $this->render('LpsaAppBundle:EvenementCategorieTable:index.html.twig', array(
            'listTablePerCategories' => $data['listTablePerCategories'],
            'listEntitiesCategoryEventTable' => $data['listEntitiesCategoryEventTable'],
            'evenementCategories' => $data['evenementCategories'],
            'entitiesTableName' => $data['entitiesTableName']
        ));
    }

    /**
     * Delete a EvenementCategorieTable entity.
     *
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        if(!empty($id) && $request->isXmlHttpRequest()){
            $evenementCategorieTable = $em->getRepository('LpsaAppBundle:EvenementCategorieTable')->findOneById($id);
            if($evenementCategorieTable){
                $em->remove($evenementCategorieTable);
                $em->flush();                
            }
        }
        $data  = $this->prepareData();

        return $this->render('LpsaAppBundle:EvenementCategorieTable:_index.html.twig', array(
            'listTablePerCategories' => $data['listTablePerCategories'],
            'listEntitiesCategoryEventTable' => $data['listEntitiesCategoryEventTable'],
            'evenementCategories' => $data['evenementCategories'],
            'entitiesTableName' => $data['entitiesTableName']
        ));
    }
    
    /**
     * Add a EvenementCategorieTable entity.
     *
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $entityName = $request->query->get('entity');
        if(!empty($id) && !empty($entityName) && $request->isXmlHttpRequest()){
            $evenementCategorie = $em->getRepository('LpsaAppBundle:EvenementCategorie')->findOneById($id);
            $tableName = $em->getClassMetadata('LpsaAppBundle:'.$entityName)->getTableName();
            $evenementCategorieTable = new EvenementCategorieTable();
            $evenementCategorieTable->setEvenementCategorie($evenementCategorie);
            $evenementCategorieTable->setNomTable($tableName);
            $em->persist($evenementCategorieTable);
            $em->flush();
        }
        $data  = $this->prepareData();
        
        return $this->render('LpsaAppBundle:EvenementCategorieTable:_index.html.twig', array(
            'listTablePerCategories' => $data['listTablePerCategories'],
            'listEntitiesCategoryEventTable' => $data['listEntitiesCategoryEventTable'],
            'evenementCategories' => $data['evenementCategories'],
            'entitiesTableName' => $data['entitiesTableName']
        ));
    }
    
    /**
     * Prepare to render view
     * 
     * @return mixed
     */
    private function prepareData(){
        $em = $this->getDoctrine()->getManager();
        $evenementCategories = $em->getRepository('LpsaAppBundle:EvenementCategorie')->findAll();
        $listTablePerCategories = array();
        foreach($evenementCategories as $evenementCategorie){
            $listTablePerCategories[$evenementCategorie->getId()] = $evenementCategorie->getEvenementCategorieTables();
        }
        $listEntitiesCategoryEventTable = $this->getParameter('list_entities_category_event_table');
        $entitiesTableName = array();
        foreach($listEntitiesCategoryEventTable as $entityName){
            $tableName = $em->getClassMetadata('LpsaAppBundle:'.$entityName)->getTableName();
            $entitiesTableName[$entityName] = $tableName;
        }
        return array(
            'evenementCategories' => $evenementCategories,
            'listTablePerCategories' => $listTablePerCategories,
            'listEntitiesCategoryEventTable' => $listEntitiesCategoryEventTable,
            'entitiesTableName' => $entitiesTableName
        );
    }
}
