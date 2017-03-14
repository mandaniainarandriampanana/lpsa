<?php

namespace Lpsa\AppBundle\Form\Handler\ExerciceUrgence;

use Lpsa\AppBundle\Entity\ExerciceUrgence;
use Symfony\Component\HttpFoundation\Request;

class NewExerciceUrgenceFormHandlerStrategy extends AbstractExerciceUrgenceFormHandlerStrategy{
    public function createForm(ExerciceUrgence $exerciceUrgence)
    {
        $this->form = $this->formFactory->create($this->exerciceUrgenceType, $exerciceUrgence, array(
            'action' => $this->router->generate('exerciceurgence_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ExerciceUrgence $exerciceUrgence)
    {
        $this->exerciceUrgenceManager->save($exerciceUrgence, true, true);

        return $this->translator->trans('exerciceurgence.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
