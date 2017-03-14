<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifDepot;

use Lpsa\AppBundle\Entity\ObjectifDepot;
use Symfony\Component\HttpFoundation\Request;

interface ObjectifDepotFormHandlerStrategyInterface {
    public function handleForm(Request $request, ObjectifDepot $objectifdepot);
    public function createForm(ObjectifDepot $objectifdepot);
    public function createView();
}
