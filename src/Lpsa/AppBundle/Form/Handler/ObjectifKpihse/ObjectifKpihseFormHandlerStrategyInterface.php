<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifKpihse;

use Lpsa\AppBundle\Entity\ObjectifKpihse;
use Symfony\Component\HttpFoundation\Request;

interface ObjectifKpihseFormHandlerStrategyInterface {
    public function handleForm(Request $request, ObjectifKpihse $objectifKpihse);
    public function createForm(ObjectifKpihse $objectifKpihse);
    public function createView();
}
