<?php

namespace Lpsa\AppBundle\Form\Handler\Service;

use Lpsa\AppBundle\Entity\Service;
use Symfony\Component\HttpFoundation\Request;

interface ServiceFormHandlerStrategyInterface {
    public function handleForm(Request $request, Service $service);
    public function createForm(Service $service);
    public function createView();
}
