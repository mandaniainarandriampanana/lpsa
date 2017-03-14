<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\Corporel;

/**
 * Corporel controller.
 *
 */
class CorporelController extends Controller
{
    /**
     * Lists all Corporel entities.
     *
     */
    public function indexAction()
    {
        $corporels = $this->getCorporelManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Corporel:index.html.twig', array(
            'corporels' => $corporels,
        ));
    }
    public function newEditAction(Request $request, Corporel $corporel=null)
    {
        $corporelProcess = $this->getCorporelFormHandler()->processForm($corporel);
        $form = $this->getCorporelFormHandler()->createForm($corporelProcess);
 
        if ($this->getCorporelFormHandler()->handleForm($form, $corporelProcess, $request)) {
            $this->addFlash('success', $this->getCorporelFormHandler()->getMessage());
            return $this->redirectToRoute('corporel_edit', array('id' => $corporelProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Corporel:newEdit.html.twig', array(
            'form' => $form->createView(),
            'corporel' => $corporelProcess,
        ));
    }

    /**
     * Deletes a Corporel entity.
     *
     */
    public function deleteAction(Request $request, Corporel $corporel)
    {
        $this->getCorporelManager()->remove($corporel);
        $this->addFlash('success', $this->get('translator')->trans('corporel.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('corporel_index');
    }

    public function getCorporelManager(){
        return $this->get('app.corporel.manager');
    }
    private function getCorporelFormHandler(){
        return $this->get('app.corporel.form.handler');
    }
}
