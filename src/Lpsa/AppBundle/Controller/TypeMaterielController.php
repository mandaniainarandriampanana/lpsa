<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\TypeMateriel;

/**
 * TypeMateriel controller.
 *
 */
class TypeMaterielController extends Controller
{
    /**
     * Lists all TypeMateriel entities.
     *
     */
    public function indexAction()
    {
        $typeMateriels = $this->getTypeMaterielManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:TypeMateriel:index.html.twig', array(
            'typeMateriels' => $typeMateriels,
        ));
    }
    public function newEditAction(Request $request, TypeMateriel $typeMateriel=null)
    {
        $typeMaterielProcess = $this->getTypeMaterielFormHandler()->processForm($typeMateriel);
        $form = $this->getTypeMaterielFormHandler()->createForm($typeMaterielProcess);
 
        if ($this->getTypeMaterielFormHandler()->handleForm($form, $typeMaterielProcess, $request)) {
            $this->addFlash('success', $this->getTypeMaterielFormHandler()->getMessage());
            return $this->redirectToRoute('typemateriel_edit', array('id' => $typeMaterielProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:TypeMateriel:newEdit.html.twig', array(
            'form' => $form->createView(),
            'typeMateriel' => $typeMaterielProcess,
        ));
    }

    /**
     * Deletes a TypeMateriel entity.
     *
     */
    public function deleteAction(Request $request, TypeMateriel $typeMateriel)
    {
        $this->getTypeMaterielManager()->remove($typeMateriel);
        $this->addFlash('success', $this->get('translator')->trans('typemateriel.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('typemateriel_index');
    }

    public function getTypeMaterielManager(){
        return $this->get('app.typemateriel.manager');
    }
    private function getTypeMaterielFormHandler(){
        return $this->get('app.typemateriel.form.handler');
    }
}
