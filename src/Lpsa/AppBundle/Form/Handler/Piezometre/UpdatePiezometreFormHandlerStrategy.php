<?php

namespace Lpsa\AppBundle\Form\Handler\Piezometre;

use Lpsa\AppBundle\Entity\Piezometre;
use Symfony\Component\HttpFoundation\Request;

class UpdatePiezometreFormHandlerStrategy extends AbstractPiezometreFormHandlerStrategy{
    
    public function createForm(Piezometre $piezometre)
    {
        $this->form = $this->formFactory->create($this->piezometreType, $piezometre, array(
            'action' => $this->router->generate('piezometre_edit',array('id' => $piezometre->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Piezometre $piezometre)
    {

        $this->piezometreManager->save($piezometre, false, true);

        return $this->translator->trans('piezometre.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
