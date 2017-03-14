<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Direction;

/**
 * Direction controller.
 *
 */
class DirectionController extends Controller
{
    /**
     * Lists all Direction entities.
     *
     */
    public function indexAction()
    {
        $directions = $this->getDirectionManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Direction:index.html.twig', array(
            'directions' => $directions,
        ));
    }
    
    public function newEditAction(Request $request, Direction $direction = null)
    {
        $directionProcess = $this->getDirectionFormHandler()->processForm($direction);
        $form = $this->getDirectionFormHandler()->createForm($directionProcess);
 
        if ($this->getDirectionFormHandler()->handleForm($form, $directionProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getDirectionFormHandler()->getMessage());
 
            return $this->redirectToRoute('direction_edit', array('id' => $directionProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Direction:newEdit.html.twig', array(
            'form' => $form->createView(),
            'direction' => $directionProcess
        )); 
    }
    
    /**
     * Delete a Direction entity.
     *
     */
    public function deleteAction(Request $request,Direction $direction)
    {
        $this->getDirectionManager()->remove($direction);
        $this->addFlash('success', $this->get('translator')->trans('direction.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('direction_index');
    }
    
    public function getDirectionFormHandler()
    {
        return $this->get('app.direction.form.handler');
    }
    
    public function getDirectionManager(){
        return $this->get('app.direction.manager');
    }
    
}
