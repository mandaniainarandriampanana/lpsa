<?php

namespace Lpsa\AppBundle\Form\Handler\TypeMateriel;

use Lpsa\AppBundle\Entity\TypeMateriel;
use Symfony\Component\HttpFoundation\Request;

interface TypeMaterielFormHandlerStrategyInterface {
    public function handleForm(Request $request, TypeMateriel $typemateriel);
    public function createForm(TypeMateriel $typemateriel);
    public function createView();
}
