<?php

namespace Lpsa\AppBundle\Form\Handler\Materiel;

use Lpsa\AppBundle\Entity\Materiel;
use Lpsa\AppBundle\Form\Type\Materiel\MaterielType;
use Symfony\Component\HttpFoundation\Request;

class NewMaterielFormHandlerStrategy extends AbstractMaterielFormHandlerStrategy{
    public function createForm(Materiel $materiel)
    {
        $this->form = $this->formFactory->create(new MaterielType(), $materiel, array(
            'action' => $this->router->generate('materiel_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Materiel $materiel)
    {
        $this->materielManager->save($materiel, true, true);

        return $this->translator->trans('materiel.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
