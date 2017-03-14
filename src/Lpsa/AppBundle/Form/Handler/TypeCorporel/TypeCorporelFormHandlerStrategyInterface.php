<?php

namespace Lpsa\AppBundle\Form\Handler\TypeCorporel;

use Lpsa\AppBundle\Entity\TypeCorporel;
use Symfony\Component\HttpFoundation\Request;

interface TypeCorporelFormHandlerStrategyInterface {
    public function handleForm(Request $request, TypeCorporel $typecorporel);
    public function createForm(TypeCorporel $typecorporel);
    public function createView();
}
