<?php

namespace Lpsa\AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TextToIntegerDataTransformer implements DataTransformerInterface{
    
    public function transform($value)
    {
        if (empty($value)) {
            return 0;
        }

        return $value;

    }
    public function reverseTransform($value)
    {
        $value = trim($value);
        if (empty($value)) {
            return 0;
        }
        $pattern =  "/([^0-9.,]+)/";

        if (preg_match($pattern, $value,$matches)) {
            throw new TransformationFailedException('La valeur doit être un entier positif.');
        }

        return intval($value);
    }
}
