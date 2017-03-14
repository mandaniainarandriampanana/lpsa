<?php

namespace Lpsa\AppBundle\Form\Handler\Laboratoire;

use Lpsa\AppBundle\Entity\Laboratoire;
use Symfony\Component\HttpFoundation\Request;

interface LaboratoireFormHandlerStrategyInterface {
    public function handleForm(Request $request, Laboratoire $laboratoire);
    public function createForm(Laboratoire $laboratoire);
    public function createView();
}
