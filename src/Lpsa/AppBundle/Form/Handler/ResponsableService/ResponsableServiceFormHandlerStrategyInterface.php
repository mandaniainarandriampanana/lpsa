<?php

namespace Lpsa\AppBundle\Form\Handler\ResponsableService;

use Lpsa\AppBundle\Entity\ResponsableService;
use Symfony\Component\HttpFoundation\Request;

interface ResponsableServiceFormHandlerStrategyInterface {
    public function handleForm(Request $request, ResponsableService $responsableService);
    public function createForm(ResponsableService $responsableService);
    public function createView();
}
