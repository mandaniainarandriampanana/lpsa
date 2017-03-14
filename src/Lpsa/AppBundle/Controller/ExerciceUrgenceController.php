<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\ExerciceUrgence;

/**
 * ExerciceUrgence controller.
 *
 */
class ExerciceUrgenceController extends Controller
{
    /**
     * Lists all ExerciceUrgence entities.
     *
     */
    public function indexAction()
    {
        $exerciceUrgences = $this->getExerciceUrgenceManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:ExerciceUrgence:index.html.twig', array(
            'exerciceUrgences' => $exerciceUrgences,
        ));
    }
    
    public function newEditAction(Request $request, ExerciceUrgence $exerciceUrgence = null)
    {
        $exerciceUrgenceProcess = $this->getExerciceUrgenceFormHandler()->processForm($exerciceUrgence);
        $form = $this->getExerciceUrgenceFormHandler()->createForm($exerciceUrgenceProcess);
 
        if ($this->getExerciceUrgenceFormHandler()->handleForm($form, $exerciceUrgenceProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getExerciceUrgenceFormHandler()->getMessage());
 
            return $this->redirectToRoute('exerciceurgence_edit', array('id' => $exerciceUrgenceProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:ExerciceUrgence:newEdit.html.twig', array(
            'form' => $form->createView(),
            'exerciceUrgence' => $exerciceUrgenceProcess
        )); 
    }
    
    /**
     * Delete a ExerciceUrgence entity.
     *
     */
    public function deleteAction(Request $request,ExerciceUrgence $exerciceUrgence)
    {
        $this->getExerciceUrgenceManager()->remove($exerciceUrgence);
        $this->addFlash('success', $this->get('translator')->trans('exerciceurgence.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('exerciceurgence_index');
    }
    
    public function getExerciceUrgenceFormHandler()
    {
        return $this->get('app.exerciceurgence.form.handler');
    }
    
    public function getExerciceUrgenceManager(){
        return $this->get('app.exerciceurgence.manager');
    }
    
}
