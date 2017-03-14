<?php

namespace Lpsa\AppBundle\Form\Handler\Corporel;

use Lpsa\AppBundle\Entity\Corporel;
use Lpsa\AppBundle\Form\Type\Corporel\CorporelType;
use Symfony\Component\HttpFoundation\Request;

class NewCorporelFormHandlerStrategy extends AbstractCorporelFormHandlerStrategy{
    public function createForm(Corporel $corporel)
    {
        $this->form = $this->formFactory->create(new CorporelType(), $corporel, array(
            'action' => $this->router->generate('corporel_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Corporel $corporel)
    {
        $this->corporelManager->save($corporel, true, true);

        return $this->translator->trans('corporel.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
