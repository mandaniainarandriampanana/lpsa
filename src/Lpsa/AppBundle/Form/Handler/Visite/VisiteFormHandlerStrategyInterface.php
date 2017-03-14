<?php

namespace Lpsa\AppBundle\Form\Handler\Visite;

use Lpsa\AppBundle\Entity\Visite;
use Symfony\Component\HttpFoundation\Request;

interface VisiteFormHandlerStrategyInterface {
    public function handleForm(Request $request, Visite $visite);
    public function createForm(Visite $visite);
    public function createView();
}
