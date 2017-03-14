<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\DepotCategorie;

/**
 * DepotCategorie controller.
 *
 */
class DepotCategorieController extends Controller
{
    /**
     * Lists all DepotCategorie entities.
     *
     */
    public function indexAction()
    {
        $depotCategories = $this->getDepotCategorieManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:DepotCategorie:index.html.twig', array(
            'depotCategories' => $depotCategories,
        ));
    }
    
    public function newEditAction(Request $request, DepotCategorie $depotCategorie = null)
    {
        $depotCategorieProcess = $this->getDepotCategorieFormHandler()->processForm($depotCategorie);
        $form = $this->getDepotCategorieFormHandler()->createForm($depotCategorieProcess);
 
        if ($this->getDepotCategorieFormHandler()->handleForm($form, $depotCategorieProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getDepotCategorieFormHandler()->getMessage());
 
            return $this->redirectToRoute('admin_depotcategorie_edit', array('id' => $depotCategorieProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:DepotCategorie:newEdit.html.twig', array(
            'form' => $form->createView(),
            'depotCategorie' => $depotCategorieProcess
        )); 
    }
    
    /**
     * Delete a DepotCategorie entity.
     *
     */
    public function deleteAction(Request $request,DepotCategorie $depotCategorie)
    {
        $this->getDepotCategorieManager()->remove($depotCategorie);
        $this->addFlash('success', $this->get('translator')->trans('depotcategorie.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_depotcategorie_index');
    }
    
    public function getDepotCategorieFormHandler()
    {
        return $this->get('app.depotcategorie.form.handler');
    }
    
    public function getDepotCategorieManager(){
        return $this->get('app.depotcategorie.manager');
    }
    
}
