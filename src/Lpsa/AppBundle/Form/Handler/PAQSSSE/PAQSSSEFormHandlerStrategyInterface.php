<?php

namespace Lpsa\AppBundle\Form\Handler\PAQSSSE;

use Lpsa\AppBundle\Entity\PAQSSSE;
use Symfony\Component\HttpFoundation\Request;

interface PAQSSSEFormHandlerStrategyInterface {
    public function handleForm(Request $request, PAQSSSE $PAQSSSE);
    public function createForm(PAQSSSE $PAQSSSE);
    public function createView();
}
