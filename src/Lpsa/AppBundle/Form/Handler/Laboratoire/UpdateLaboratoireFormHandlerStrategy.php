<?php

namespace Lpsa\AppBundle\Form\Handler\Laboratoire;

use Lpsa\AppBundle\Entity\Laboratoire;
use Symfony\Component\HttpFoundation\Request;

class UpdateLaboratoireFormHandlerStrategy extends AbstractLaboratoireFormHandlerStrategy{
    
    public function createForm(Laboratoire $laboratoire)
    {
        $this->form = $this->formFactory->create($this->laboratoireType, $laboratoire, array(
            'action' => $this->router->generate('laboratoire_edit',array('id' => $laboratoire->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Laboratoire $laboratoire)
    {

        $this->laboratoireManager->save($laboratoire, false, true);

        return $this->translator->trans('laboratoire.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
