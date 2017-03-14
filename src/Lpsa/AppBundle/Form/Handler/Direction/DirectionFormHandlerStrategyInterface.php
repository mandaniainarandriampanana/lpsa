<?php

namespace Lpsa\AppBundle\Form\Handler\Direction;

use Lpsa\AppBundle\Entity\Direction;
use Symfony\Component\HttpFoundation\Request;

interface DirectionFormHandlerStrategyInterface {
    public function handleForm(Request $request, Direction $direction);
    public function createForm(Direction $direction);
    public function createView();
}
