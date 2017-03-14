<?php

namespace Lpsa\AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TextToDecimalDataTransformer implements DataTransformerInterface {
    public function transform($value)
    {
        if (empty($value)) {
            return 0.00;
        }

        return $value;

    }
    public function reverseTransform($value)
    {
        if(!preg_match("#^[0-9]+([,.][0-9]+)?$#",$value)){
            throw new TransformationFailedException('Entrée invalide');
        }
        return floatval(str_replace(',', '.', $value));
    }
}
