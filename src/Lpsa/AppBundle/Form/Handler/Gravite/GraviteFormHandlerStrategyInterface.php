<?php

namespace Lpsa\AppBundle\Form\Handler\Gravite;

use Lpsa\AppBundle\Entity\Gravite;
use Symfony\Component\HttpFoundation\Request;

interface GraviteFormHandlerStrategyInterface {
    public function handleForm(Request $request, Gravite $gravite);
    public function createForm(Gravite $gravite);
    public function createView();
}
