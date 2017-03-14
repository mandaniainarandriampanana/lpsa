<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\TypeCorporel;

/**
 * TypeCorporel controller.
 *
 */
class TypeCorporelController extends Controller
{
    /**
     * Lists all TypeCorporel entities.
     *
     */
    public function indexAction()
    {
        $typeCorporels = $this->getTypeCorporelManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:TypeCorporel:index.html.twig', array(
            'typeCorporels' => $typeCorporels,
        ));
    }
    public function newEditAction(Request $request, TypeCorporel $typeCorporel=null)
    {
        $typeCorporelProcess = $this->getTypeCorporelFormHandler()->processForm($typeCorporel);
        $form = $this->getTypeCorporelFormHandler()->createForm($typeCorporelProcess);
 
        if ($this->getTypeCorporelFormHandler()->handleForm($form, $typeCorporelProcess, $request)) {
            $this->addFlash('success', $this->getTypeCorporelFormHandler()->getMessage());
            return $this->redirectToRoute('typecorporel_edit', array('id' => $typeCorporelProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:TypeCorporel:newEdit.html.twig', array(
            'form' => $form->createView(),
            'typeCorporel' => $typeCorporelProcess,
        ));
    }

    /**
     * Deletes a TypeCorporel entity.
     *
     */
    public function deleteAction(Request $request, TypeCorporel $typeCorporel)
    {
        $this->getTypeCorporelManager()->remove($typeCorporel);
        $this->addFlash('success', $this->get('translator')->trans('typecorporel.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('typecorporel_index');
    }

    public function getTypeCorporelManager(){
        return $this->get('app.typecorporel.manager');
    }
    private function getTypeCorporelFormHandler(){
        return $this->get('app.typecorporel.form.handler');
    }
}
