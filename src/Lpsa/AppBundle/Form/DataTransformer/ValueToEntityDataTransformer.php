<?php

namespace Lpsa\AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class ValueToEntityDataTransformer implements DataTransformerInterface{
    
    private $manager;
    private $entityClass;
    
    public function __construct(ObjectManager $manager, $entityClass) {
        $this->manager = $manager;
        $this->entityClass = $entityClass;
    }
    
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        return $value;

    }
    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }
        $entity = $this->manager->getRepository($this->entityClass)->findOneById($value);
        if (null === $entity) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An entity with number "%s" does not exist!',
                $value
            ));
        }

        return $entity;
    }
}
