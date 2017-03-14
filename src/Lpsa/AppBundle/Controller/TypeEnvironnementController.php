<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\TypeEnvironnement;

/**
 * TypeEnvironnement controller.
 *
 */
class TypeEnvironnementController extends Controller
{
    /**
     * Lists all TypeEnvironnement entities.
     *
     */
    public function indexAction()
    {
        $typeEnvironnements = $this->getTypeEnvironnementManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:TypeEnvironnement:index.html.twig', array(
            'typeEnvironnements' => $typeEnvironnements,
        ));
    }
    public function newEditAction(Request $request, TypeEnvironnement $typeEnvironnement=null)
    {
        $typeEnvironnementProcess = $this->getTypeEnvironnementFormHandler()->processForm($typeEnvironnement);
        $form = $this->getTypeEnvironnementFormHandler()->createForm($typeEnvironnementProcess);
 
        if ($this->getTypeEnvironnementFormHandler()->handleForm($form, $typeEnvironnementProcess, $request)) {
            $this->addFlash('success', $this->getTypeEnvironnementFormHandler()->getMessage());
            return $this->redirectToRoute('typeenvironnement_edit', array('id' => $typeEnvironnementProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:TypeEnvironnement:newEdit.html.twig', array(
            'form' => $form->createView(),
            'typeEnvironnement' => $typeEnvironnementProcess,
        ));
    }

    /**
     * Deletes a TypeEnvironnement entity.
     *
     */
    public function deleteAction(Request $request, TypeEnvironnement $typeEnvironnement)
    {
        $this->getTypeEnvironnementManager()->remove($typeEnvironnement);
        $this->addFlash('success', $this->get('translator')->trans('typeenvironnement.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('typeenvironnement_index');
    }

    public function getTypeEnvironnementManager(){
        return $this->get('app.typeenvironnement.manager');
    }
    private function getTypeEnvironnementFormHandler(){
        return $this->get('app.typeenvironnement.form.handler');
    }
}
