<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifLtirTrir;

use Lpsa\AppBundle\Entity\ObjectifLtirTrir;
use Symfony\Component\HttpFoundation\Request;

interface ObjectifLtirTrirFormHandlerStrategyInterface {
    public function handleForm(Request $request, ObjectifLtirTrir $objectifLtirTrir);
    public function createForm(ObjectifLtirTrir $objectifLtirTrir);
    public function createView();
}
