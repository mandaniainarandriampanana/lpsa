<?php

namespace Lpsa\AppBundle\Form\Handler\Corporel;

use Lpsa\AppBundle\Entity\Corporel;
use Symfony\Component\HttpFoundation\Request;

interface CorporelFormHandlerStrategyInterface {
    public function handleForm(Request $request, Corporel $corporel);
    public function createForm(Corporel $corporel);
    public function createView();
}
