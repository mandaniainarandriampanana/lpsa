<?php

namespace Lpsa\AppBundle\Form\Handler\Corporel;

use Lpsa\AppBundle\Entity\Corporel;
use Lpsa\AppBundle\Form\Type\Corporel\CorporelType;
use Symfony\Component\HttpFoundation\Request;

class UpdateCorporelFormHandlerStrategy extends AbstractCorporelFormHandlerStrategy{
    
    public function createForm(Corporel $corporel)
    {
        $this->form = $this->formFactory->create(new CorporelType(), $corporel, array(
            'action' => $this->router->generate('corporel_edit',array('id' => $corporel->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Corporel $corporel)
    {

        $this->corporelManager->save($corporel, false, true);

        return $this->translator->trans('corporel.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
