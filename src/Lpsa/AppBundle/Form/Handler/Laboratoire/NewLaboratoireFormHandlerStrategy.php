<?php

namespace Lpsa\AppBundle\Form\Handler\Laboratoire;

use Lpsa\AppBundle\Entity\Laboratoire;
use Symfony\Component\HttpFoundation\Request;

class NewLaboratoireFormHandlerStrategy extends AbstractLaboratoireFormHandlerStrategy{
    public function createForm(Laboratoire $laboratoire)
    {
        $this->form = $this->formFactory->create($this->laboratoireType, $laboratoire, array(
            'action' => $this->router->generate('laboratoire_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Laboratoire $laboratoire)
    {
        $this->laboratoireManager->save($laboratoire, true, true);

        return $this->translator->trans('laboratoire.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
