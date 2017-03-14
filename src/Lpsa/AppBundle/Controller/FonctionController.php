<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Fonction;

/**
 * Fonction controller.
 *
 */
class FonctionController extends Controller
{
    /**
     * Lists all Fonction entities.
     *
     */
    public function indexAction()
    {
        $fonctions = $this->getFonctionManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Fonction:index.html.twig', array(
            'fonctions' => $fonctions,
        ));
    }
    
    public function newEditAction(Request $request, Fonction $fonction = null)
    {
        $fonctionProcess = $this->getFonctionFormHandler()->processForm($fonction);
        $form = $this->getFonctionFormHandler()->createForm($fonctionProcess);
 
        if ($this->getFonctionFormHandler()->handleForm($form, $fonctionProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getFonctionFormHandler()->getMessage());
 
            return $this->redirectToRoute('admin_fonction_edit', array('id' => $fonctionProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Fonction:newEdit.html.twig', array(
            'form' => $form->createView(),
            'fonction' => $fonctionProcess
        )); 
    }
    
    /**
     * Delete a Fonction entity.
     *
     */
    public function deleteAction(Request $request,Fonction $fonction)
    {
        $this->getFonctionManager()->remove($fonction);
        $this->addFlash('success', $this->get('translator')->trans('fonction.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_fonction_index');
    }
    
    public function getFonctionFormHandler()
    {
        return $this->get('app.fonction.form.handler');
    }
    
    public function getFonctionManager(){
        return $this->get('app.fonction.manager');
    }
    
}
