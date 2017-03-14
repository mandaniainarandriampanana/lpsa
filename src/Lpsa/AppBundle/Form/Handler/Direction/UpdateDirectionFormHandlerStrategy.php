<?php

namespace Lpsa\AppBundle\Form\Handler\Direction;

use Lpsa\AppBundle\Entity\Direction;
use Lpsa\AppBundle\Form\Type\Direction\DirectionType;
use Symfony\Component\HttpFoundation\Request;

class UpdateDirectionFormHandlerStrategy extends AbstractDirectionFormHandlerStrategy{
    
    public function createForm(Direction $direction)
    {
        $this->form = $this->formFactory->create(new DirectionType(), $direction, array(
            'action' => $this->router->generate('direction_edit',array('id' => $direction->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Direction $direction)
    {

        $this->directionManager->save($direction, false, true);

        return $this->translator->trans('direction.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
