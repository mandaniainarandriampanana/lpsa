<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\HeureTravailCategorie;

/**
 * HeureTravailCategorie controller.
 *
 */
class HeureTravailCategorieController extends Controller
{
    /**
     * Lists all HeureTravailCategorie entities.
     *
     */
    public function indexAction()
    {
        $heureTravailCategoriex = $this->getHeureTravailCategorieManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:HeureTravailCategorie:index.html.twig', array(
            'heureTravailCategoriex' => $heureTravailCategoriex,
        ));
    }
    
    public function newEditAction(Request $request, HeureTravailCategorie $heureTravailCategorie = null)
    {
        $heureTravailCategorieProcess = $this->getHeureTravailCategorieFormHandler()->processForm($heureTravailCategorie);
        $form = $this->getHeureTravailCategorieFormHandler()->createForm($heureTravailCategorieProcess);
 
        if ($this->getHeureTravailCategorieFormHandler()->handleForm($form, $heureTravailCategorieProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getHeureTravailCategorieFormHandler()->getMessage());
 
            return $this->redirectToRoute('heuretravailcategorie_edit', array('id' => $heureTravailCategorieProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:HeureTravailCategorie:newEdit.html.twig', array(
            'form' => $form->createView(),
            'heureTravailCategorie' => $heureTravailCategorieProcess
        )); 
    }
    
    /**
     * Delete a HeureTravailCategorie entity.
     *
     */
    public function deleteAction(Request $request,HeureTravailCategorie $heureTravailCategorie)
    {
        $this->getHeureTravailCategorieManager()->remove($heureTravailCategorie);
        $this->addFlash('success', $this->get('translator')->trans('heuretravailcategorie.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('heuretravailcategorie_index');
    }
    
    public function getHeureTravailCategorieFormHandler()
    {
        return $this->get('app.heuretravailcategorie.form.handler');
    }
    
    public function getHeureTravailCategorieManager(){
        return $this->get('app.heuretravailcategorie.manager');
    }
    
}
