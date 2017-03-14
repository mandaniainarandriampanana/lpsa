<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\Materiel;

/**
 * Materiel controller.
 *
 */
class MaterielController extends Controller
{
    /**
     * Lists all Materiel entities.
     *
     */
    public function indexAction()
    {
        $materiels = $this->getMaterielManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Materiel:index.html.twig', array(
            'materiels' => $materiels,
        ));
    }
    public function newEditAction(Request $request, Materiel $materiel=null)
    {
        $materielProcess = $this->getMaterielFormHandler()->processForm($materiel);
        $form = $this->getMaterielFormHandler()->createForm($materielProcess);
 
        if ($this->getMaterielFormHandler()->handleForm($form, $materielProcess, $request)) {
            $this->addFlash('success', $this->getMaterielFormHandler()->getMessage());
            return $this->redirectToRoute('materiel_edit', array('id' => $materielProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Materiel:newEdit.html.twig', array(
            'form' => $form->createView(),
            'materiel' => $materielProcess,
        ));
    }

    /**
     * Deletes a Materiel entity.
     *
     */
    public function deleteAction(Request $request, Materiel $materiel)
    {
        $this->getMaterielManager()->remove($materiel);
        $this->addFlash('success', $this->get('translator')->trans('materiel.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('materiel_index');
    }

    public function getMaterielManager(){
        return $this->get('app.materiel.manager');
    }
    private function getMaterielFormHandler(){
        return $this->get('app.materiel.form.handler');
    }
}
