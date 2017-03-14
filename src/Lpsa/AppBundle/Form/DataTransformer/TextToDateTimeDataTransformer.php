<?php

namespace Lpsa\AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TextToDateTimeDataTransformer implements DataTransformerInterface{
    
    /**
     *
     * @var bool 
     */
    private $hasDefault;
    
    /**
     * 
     * @param bool $hasDefault
     */
    public function __construct($hasDefault = false) {
        $this->hasDefault = $hasDefault;
    }
    
    public function transform($datetime)
    {
        if (null === $datetime) {
            if($this->hasDefault){
                $dt = new \DateTime('now');
                return $dt->format('d'). '/' .$dt->format('m'). '/' .$dt->format('Y');
            } else {
                return '';                
            }
        }

        if (!is_object($datetime)) {
            throw new TransformationFailedException('Expected a datetime.');
        }

        return $datetime->format('d'). '/' .$datetime->format('m'). '/' .$datetime->format('Y');

    }
    public function reverseTransform($stringDate)
    {
        if (null === $stringDate) {
            return NULL;
        }

        if (!is_string($stringDate)) {
            throw new TransformationFailedException('Expected a string.');
        }

        return \DateTime::createFromFormat('d/m/Y', $stringDate);
    }
}
