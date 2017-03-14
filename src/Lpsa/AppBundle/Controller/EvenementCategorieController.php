<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\EvenementCategorie;

/**
 * EvenementCategorie controller.
 *
 */
class EvenementCategorieController extends Controller
{
    /**
     * Lists all EvenementCategorie entities.
     *
     */
    public function indexAction()
    {
        $evenementCategories = $this->getEvenementCategorieManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:EvenementCategorie:index.html.twig', array(
            'evenementCategories' => $evenementCategories,
        ));
    }
    
    public function newEditAction(Request $request, EvenementCategorie $evenementCategorie=null)
    {
        $evenementCategorieProcess = $this->getEvenementCategorieFormHandler()->processForm($evenementCategorie);
        $form = $this->getEvenementCategorieFormHandler()->createForm($evenementCategorieProcess);
 
        if ($this->getEvenementCategorieFormHandler()->handleForm($form, $evenementCategorieProcess, $request)) {
            $this->addFlash('success', $this->getEvenementCategorieFormHandler()->getMessage());
 
            return $this->redirectToRoute('evenementcategorie_edit', array('id' => $evenementCategorieProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:EvenementCategorie:newEdit.html.twig', array(
            'form' => $form->createView(),
            'evenementCategorie' => $evenementCategorieProcess,
        ));
    }

    /**
     * Deletes a EvenementCategorie entity.
     *
     */
    public function deleteAction(Request $request, EvenementCategorie $evenementCategorie)
    {
        $this->getEvenementCategorieManager()->remove($evenementCategorie);
        $this->addFlash('success', $this->get('translator')->trans('evenementcategorie.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('evenementcategorie_index');
    }
    
    private function getEvenementCategorieManager(){
        return $this->get('app.evenementcategorie.manager');
    }
    private function getEvenementCategorieFormHandler(){
        return $this->get('app.evenementcategorie.form.handler');
    }
}
