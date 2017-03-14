<?php

namespace Lpsa\AppBundle\Form\Handler\Piezometre;

use Lpsa\AppBundle\Entity\Piezometre;
use Symfony\Component\HttpFoundation\Request;

class NewPiezometreFormHandlerStrategy extends AbstractPiezometreFormHandlerStrategy{
    public function createForm(Piezometre $piezometre)
    {
        $this->form = $this->formFactory->create($this->piezometreType, $piezometre, array(
            'action' => $this->router->generate('piezometre_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Piezometre $piezometre)
    {
        $this->piezometreManager->save($piezometre, true, true);

        return $this->translator->trans('piezometre.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
