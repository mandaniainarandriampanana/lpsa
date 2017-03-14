<?php

namespace Lpsa\AppBundle\Form\Handler\ExerciceUrgence;

use Lpsa\AppBundle\Entity\ExerciceUrgence;
use Symfony\Component\HttpFoundation\Request;

class UpdateExerciceUrgenceFormHandlerStrategy extends AbstractExerciceUrgenceFormHandlerStrategy{
    
    public function createForm(ExerciceUrgence $exerciceUrgence)
    {
        $this->form = $this->formFactory->create($this->exerciceUrgenceType, $exerciceUrgence, array(
            'action' => $this->router->generate('exerciceurgence_edit',array('id' => $exerciceUrgence->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ExerciceUrgence $exerciceUrgence)
    {

        $this->exerciceUrgenceManager->save($exerciceUrgence, false, true);

        return $this->translator->trans('exerciceurgence.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
